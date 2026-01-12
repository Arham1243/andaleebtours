<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelInsurance;
use App\Models\Config;
use Illuminate\Http\Request;

class TravelInsuranceController extends Controller
{

    protected $insuranceCommissionPercentage;

    public function __construct()
    {
        $config = Config::pluck('config_value', 'config_key')->toArray();
        $this->insuranceCommissionPercentage = $config['INSURANCE_COMMISSION_PERCENTAGE'] ?? 30;
    }

    public function index()
    {
        $insurances = TravelInsurance::with('passengers', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.travel-insurances.list', compact('insurances'))->with('title', 'Travel Insurance Bookings');
    }

    public function show($id)
    {
        $insurance = TravelInsurance::with('passengers', 'user')->findOrFail($id);

        $commissionPercentage = $this->insuranceCommissionPercentage / 100;

        return view('admin.travel-insurances.show', compact('insurance', 'commissionPercentage'))->with('title', 'Insurance ' . $insurance->insurance_number);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,confirmed,active,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $insurance = TravelInsurance::findOrFail($id);
        $insurance->update($validatedData);

        return redirect()->route('admin.travel-insurances.show', $id)->with('notify_success', 'Insurance booking updated successfully.');
    }
}
