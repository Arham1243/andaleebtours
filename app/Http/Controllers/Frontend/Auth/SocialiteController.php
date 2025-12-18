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
    /**
     * Redirect the user to the social platform authentication page.
     *
     * @param  string  $social
     */
    public function redirectToProvider($social, Request $request)
    {
        // Store the intended URL in the session
        $request->session()->put('url.intended', url()->previous());

        return Socialite::driver($social)->stateless()->redirect();
    }

    /**
     * Obtain the user information from the social platform.
     *
     * @param  string  $social
     */
    public function handleProviderCallback($social, Request $request)
    {
        try {
            $socialUser = Socialite::driver($social)->stateless()->user();

            // Split full name into first and last names
            $nameParts = explode(' ', $socialUser->name, 2);
            $firstName = $nameParts[0] ?? null;
            $lastName = $nameParts[1] ?? null;

            // Find user by social_id or email
            $user = User::where('social_id', $socialUser->id)
                ->orWhere('email', $socialUser->email)
                ->first();

            if ($user) {
                // Update existing user
                $user->update([
                    'social_id' => $socialUser->id,
                    'auth_provider' => $social,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $socialUser->email,
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'social_id' => $socialUser->id,
                    'auth_provider' => $social,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $socialUser->email,
                ]);
            }

            Auth::login($user);

            $redirectTo = $request->session()->pull('url.intended', route('frontend.index'));

            return redirect()->to($redirectTo)->with('notify_success', 'Login Successful!');
        } catch (Exception $e) {
            return redirect()->route('frontend.index')
                ->with('notify_error', 'Failed to login using ' . ucfirst($social) . ': ' . $e->getMessage());
        }
    }
}
