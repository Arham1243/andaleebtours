<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\TravelInsurance;
use App\Models\TravelInsurancePassenger;
use App\Services\TravelInsuranceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TravelInsuranceController extends Controller
{
    protected $insuranceService;

    public function __construct(TravelInsuranceService $insuranceService)
    {
        $this->insuranceService = $insuranceService;
    }

    public function index(Request $request)
    {
        if ($request->has('origin') && $request->has('destination')) {
            try {
                $params = [
                    'origin' => $request->input('origin'),
                    'destination' => $request->input('destination'),
                    'start_date' => $request->input('start_date'),
                    'return_date' => $request->input('return_date'),
                    'residence_country' => $request->input('residence_country'),
                    'adult_count' => $request->input('adult_count', 0),
                    'children_count' => $request->input('children_count', 0),
                    'infant_count' => $request->input('infant_count', 0),
                    'adult_ages' => $request->input('adult_ages', []),
                    'children_ages' => $request->input('children_ages', []),
                ];

                $data = $this->insuranceService->getAvailablePlans($params);
                
                return view('frontend.travel-insurance.index', compact('data'));
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to fetch insurance plans: ' . $e->getMessage());
            }
        }

        return view('frontend.travel-insurance.index');
    }

    public function details(Request $request)
    {
        $countries = Country::orderBy('name', 'asc')->get();
        $selectedPlanData = null;

        if ($request->has('plan') && $request->has('origin') && $request->has('destination')) {
            try {
                $params = [
                    'origin' => $request->input('origin'),
                    'destination' => $request->input('destination'),
                    'start_date' => $request->input('start_date'),
                    'return_date' => $request->input('return_date'),
                    'residence_country' => $request->input('residence_country'),
                    'adult_count' => $request->input('adult_count', 0),
                    'children_count' => $request->input('children_count', 0),
                    'infant_count' => $request->input('infant_count', 0),
                    'adult_ages' => $request->input('adult_ages', []),
                    'children_ages' => $request->input('children_ages', []),
                ];

                $data = $this->insuranceService->getAvailablePlans($params);
                $selectedPlan = $request->input('plan');
                [$planCode, $ssrFeeCode] = explode('~', $selectedPlan);

                // Find the selected plan from available plans or upsell plans
                $allPlans = array_merge(
                    $data['available_plans'] ?? [],
                    array_map(function($group) {
                        return $group['UpsellPlans']['UpsellPlan'] ?? [];
                    }, $data['available_upsell_plans'] ?? [])
                );

                foreach ($allPlans as $plan) {
                    if (isset($plan['PlanCode']) && $plan['PlanCode'] === $planCode && 
                        isset($plan['SSRFeeCode']) && $plan['SSRFeeCode'] === $ssrFeeCode) {
                        $selectedPlanData = $plan;
                        break;
                    }
                }
            } catch (\Exception $e) {
                // If API fails, continue without plan data
            }
        }

        return view('frontend.travel-insurance.details', compact('countries', 'selectedPlanData'));
    }

    public function processPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'plan_code' => 'required|string',
                'ssr_fee_code' => 'required|string',
                'origin' => 'required|string',
                'destination' => 'required|string',
                'start_date' => 'required|date',
                'return_date' => 'required|date',
                'adult_count' => 'required|integer|min:0',
                'children_count' => 'required|integer|min:0',
                'infant_count' => 'required|integer|min:0',
                'residence_country' => 'required|string',
                'payment_method' => 'required|in:payby,tabby',
                'lead.fname' => 'required|string',
                'lead.email' => 'required|email',
                'lead.number' => 'required|string',
                'lead.country_of_residence' => 'required|string',
                'adult.*.dob' => 'required|date|before:today',
                'child.*.dob' => 'required|date|before:today',
                'infant.*.dob' => 'required|date|before:today',
            ]);

            $adultCount = $request->input('adult_count', 0);
            $childCount = $request->input('children_count', 0);
            $infantCount = $request->input('infant_count', 0);

            if ($adultCount > 0 && $request->has('adult')) {
                foreach ($request->input('adult.dob', []) as $index => $dob) {
                    $age = \Carbon\Carbon::parse($dob)->age;
                    if ($age < 18) {
                        return back()->with('error', 'Adult passenger #' . ($index + 1) . ' must be 18 years or older.');
                    }
                }
            }

            if ($childCount > 0 && $request->has('child')) {
                foreach ($request->input('child.dob', []) as $index => $dob) {
                    $age = \Carbon\Carbon::parse($dob)->age;
                    if ($age < 2 || $age >= 18) {
                        return back()->with('error', 'Child passenger #' . ($index + 1) . ' must be between 2 and 17 years old.');
                    }
                }
            }

            if ($infantCount > 0 && $request->has('infant')) {
                foreach ($request->input('infant.dob', []) as $index => $dob) {
                    $age = \Carbon\Carbon::parse($dob)->age;
                    if ($age >= 2) {
                        return back()->with('error', 'Infant passenger #' . ($index + 1) . ' must be under 2 years old.');
                    }
                }
            }

            $data = $request->all();
            $data['total_premium'] = $request->input('total_premium', 0);

            $insurance = $this->insuranceService->createInsuranceRecord($data);

            $redirectUrl = $this->insuranceService->getRedirectUrl($insurance, $data['payment_method']);

            return redirect($redirectUrl);
        } catch (\Exception $e) {
            Log::error('Travel Insurance Payment Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Failed to process payment: ' . $e->getMessage());
        }
    }

    public function paymentSuccess(Request $request, $insurance)
    {
        try {
            $insurance = TravelInsurance::findOrFail($insurance);

            if ($insurance->payment_method === 'payby') {
                $verification = $this->insuranceService->verifyPayByPayment($insurance);
            } else {
                $verification = $this->insuranceService->verifyTabbyPayment($insurance);
            }

            if ($verification['success']) {
                $paymentData = $verification['data'];
                
                // Save PayBy specific data
                if ($insurance->payment_method === 'payby') {
                    $insurance->update([
                        'payby_merchant_order_no' => $paymentData['body']['acquireOrder']['merchantOrderNo'] ?? null,
                        'payby_order_no' => $paymentData['body']['acquireOrder']['orderNo'] ?? null,
                        'payby_payment_response' => json_encode($paymentData),
                    ]);
                }
                
                // Update payment status
                $insurance->update([
                    'payment_status' => 'paid',
                    'payment_response' => json_encode($paymentData)
                ]);

                // Call confirm purchase API to get policy details
                $confirmResult = $this->insuranceService->confirmPurchase($insurance);

                if ($confirmResult['success']) {
                    $confirmData = $confirmResult['data'];
                    $purchaseResponse = $confirmData['PurchaseResponse'] ?? $confirmData['ConfirmPurchaseResponse'] ?? [];
                    
                    $proposalState = $purchaseResponse['ProposalState'] ?? null;
                    $isConfirmed = $proposalState === 'CONFIRMED';
                    $errorCode = $purchaseResponse['ErrorCode'] ?? null;

                    // Update insurance with confirmation data
                    $insurance->update([
                        'proposal_state' => $proposalState,
                        'policy_numbers' => $purchaseResponse['PolicyNo'] ?? null,
                        'confirmed_passengers' => json_encode($purchaseResponse['ConfirmedPassengers'] ?? []),
                        'error_messages' => json_encode($purchaseResponse['ErrorMessage'] ?? []),
                        'booking_confirmed' => $isConfirmed,
                        'confirmation_response' => json_encode($confirmData),
                        'status' => $isConfirmed ? 'confirmed' : 'pending',
                    ]);

                    // Update passenger policy details
                    if ($isConfirmed && isset($purchaseResponse['ConfirmedPassengers']['ConfirmedPassenger'])) {
                        $confirmedPassengers = $purchaseResponse['ConfirmedPassengers']['ConfirmedPassenger'];
                        
                        // Handle single passenger (not array of arrays)
                        if (isset($confirmedPassengers['FirstName'])) {
                            $confirmedPassengers = [$confirmedPassengers];
                        }

                        foreach ($confirmedPassengers as $confirmedPassenger) {
                            $passenger = TravelInsurancePassenger::where('travel_insurance_id', $insurance->id)
                                ->where('passport_number', $confirmedPassenger['IdentityNo'] ?? '')
                                ->where('date_of_birth', $confirmedPassenger['DOB'] ?? '')
                                ->where('last_name', $confirmedPassenger['LastName'] ?? '')
                                ->where('first_name', $confirmedPassenger['FirstName'] ?? '')
                                ->first();

                            if ($passenger) {
                                $passenger->update([
                                    'policy_number' => $confirmedPassenger['PolicyNo'] ?? null,
                                    'policy_url_link' => $confirmedPassenger['PolicyURLLink'] ?? null,
                                    'insurance_details' => json_encode($confirmedPassenger),
                                ]);
                            }
                        }
                    }

                    Log::info('Travel Insurance Confirmed', [
                        'insurance_id' => $insurance->id,
                        'proposal_state' => $proposalState,
                        'booking_confirmed' => $isConfirmed
                    ]);
                } else {
                    Log::warning('Travel Insurance Confirmation Failed', [
                        'insurance_id' => $insurance->id,
                        'error' => $confirmResult['error'] ?? 'Unknown error'
                    ]);
                }

                return view('frontend.travel-insurance.payment-success', compact('insurance'));
            } else {
                $insurance->update([
                    'payment_status' => 'failed',
                    'payment_response' => json_encode($verification)
                ]);

                return redirect()->route('frontend.travel-insurance.payment.failed')
                    ->with('error', 'Payment verification failed: ' . ($verification['error'] ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            Log::error('Travel Insurance Payment Success Error', [
                'insurance_id' => $insurance,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('frontend.travel-insurance.payment.failed')
                ->with('error', 'An error occurred while verifying your payment.');
        }
    }

    public function paymentFailed(Request $request)
    {
        $insuranceId = $request->input('insurance');
        $insurance = null;

        if ($insuranceId) {
            $insurance = TravelInsurance::find($insuranceId);
            if ($insurance) {
                $insurance->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled'
                ]);
            }
        }

        return view('frontend.travel-insurance.payment-failed', compact('insurance'));
    }
}
