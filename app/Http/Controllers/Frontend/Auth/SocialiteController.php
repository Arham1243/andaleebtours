<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($social, Request $request)
    {
        $request->session()->put('url.intended', url()->previous());

        return Socialite::driver($social)->stateless()->redirect();
    }

    public function handleProviderCallback($social, Request $request)
    {
        try {
            $socialUser = Socialite::driver($social)->stateless()->user();

            // Name handling
            $nameParts = explode(' ', $socialUser->name ?? '', 2);
            $firstName = $nameParts[0] ?? null;
            $lastName  = $nameParts[1] ?? null;

            // Always try email first
            $user = User::where('email', $socialUser->email)->first();

            if ($user) {
                /**
                 * Existing user
                 */

                // Link Google if not already linked
                if (empty($user->social_id)) {
                    $user->update([
                        'social_id' => $socialUser->id,
                    ]);
                }

                // Do NOT override auth_provider if user is local
                if ($user->auth_provider === null) {
                    $user->update([
                        'auth_provider' => $social,
                    ]);
                }
            } else {
                /**
                 * New Google user
                 */
                $user = User::create([
                    'email'         => $socialUser->email,
                    'first_name'    => $firstName,
                    'last_name'     => $lastName,
                    'auth_provider' => $social,
                    'social_id'     => $socialUser->id,
                    'password'      => null,
                ]);
            }

            Auth::login($user);

            $redirectTo = $request->session()->pull('url.intended');

            if ($redirectTo) {
                return redirect()->to($redirectTo)
                    ->with('notify_success', 'Login successful');
            }

            return redirect()->route('frontend.index')
                ->with('notify_success', 'Login successful');
        } catch (Exception $e) {
            return redirect()->route('frontend.index')
                ->with(
                    'notify_error',
                    'Failed to login using ' . ucfirst($social)
                );
        }
    }
}
