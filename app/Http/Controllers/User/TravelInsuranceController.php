<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TravelInsurance;
use App\Models\Country;
use App\Models\Config;
use App\Services\TravelInsuranceService;
use Illuminate\Http\Request;

class TravelInsuranceController extends Controller
{
    protected $insuranceService;
    protected $insuranceCommissionPercentage;

    public function __construct(TravelInsuranceService $insuranceService)
    {
        $this->insuranceService = $insuranceService;
        $config = Config::pluck('config_value', 'config_key')->toArray();
        $this->insuranceCommissionPercentage = $config['INSURANCE_COMMISSION_PERCENTAGE'] ?? 30;
    }

    public function index()
    {
        $user = auth()->user();

        $insurances = TravelInsurance::with('passengers')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('lead_email', $user->email);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.travel-insurances.list', compact('insurances'))->with('title', 'My Travel Insurance');
    }

    public function show($id)
    {
        $user = auth()->user();

        $insurance = TravelInsurance::with('passengers')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('lead_email', $user->email);
            })
            ->findOrFail($id);

        $commissionPercentage = $this->insuranceCommissionPercentage / 100;

        return view('user.travel-insurances.show', compact('insurance', 'commissionPercentage'))->with('title', 'Insurance ' . $insurance->insurance_number);
    }

    public function payAgain($id)
    {
        $user = auth()->user();

        $insurance = TravelInsurance::with('passengers')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('lead_email', $user->email);
            })
            ->where(function ($query) {
                $query->where('payment_status', 'pending')
                    ->orWhere('payment_status', 'failed');
            })
            ->findOrFail($id);

        return view('user.travel-insurances.pay-again', compact('insurance'))->with('title', 'Pay Again');
    }

    public function proceedPayAgain(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:payby,tabby',
        ]);

        $user = auth()->user();

        $insurance = TravelInsurance::with('passengers')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('lead_email', $user->email);
            })
            ->where(function ($query) {
                $query->where('payment_status', 'pending')
                    ->orWhere('payment_status', 'failed');
            })
            ->findOrFail($id);

        $insurance->update([
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

        try {
            $redirectUrl = $this->insuranceService->getRedirectUrl($insurance, $request->payment_method);
            return redirect($redirectUrl);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to process payment: ' . $e->getMessage());
        }
    }
}
