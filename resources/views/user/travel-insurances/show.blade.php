@extends('user.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('user.travel-insurances.show', $insurance) }}
            <div class="custom-sec custom-sec--form">
                <div class="custom-sec__header">
                    <div class="section-content">
                        <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                    </div>
                    @if ($insurance->payment_status === 'failed' || $insurance->payment_status === 'pending')
                        <a href="{{ route('user.travel-insurances.pay-again', $insurance->id) }}" class="themeBtn">
                            Pay Now
                        </a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-wrapper">

                        <div class="form-box">
                            <div class="form-box__header">
                                <div class="title">Insurance Summary</div>
                            </div>
                            <div class="form-box__body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>Insurance Number:</strong></td>
                                                <td class="text-end">{{ $insurance->insurance_number }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Booking Date:</strong></td>
                                                <td class="text-end">{{ formatDate($insurance->created_at) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Plan Title:</strong></td>
                                                <td class="text-end">{{ $insurance->plan_title ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Travel Dates:</strong></td>
                                                <td class="text-end">
                                                    {{ $insurance->start_date ? formatDate($insurance->start_date) : 'N/A' }} 
                                                    to 
                                                    {{ $insurance->return_date ? formatDate($insurance->return_date) : 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Origin → Destination:</strong></td>
                                                <td class="text-end">{{ $insurance->origin ?? 'N/A' }} → {{ $insurance->destination ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Method:</strong></td>
                                                <td class="text-end">{{ strtoupper($insurance->payment_method ?? 'N/A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Status:</strong></td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $insurance->payment_status == 'paid' ? 'success' : ($insurance->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($insurance->payment_status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Booking Status:</strong></td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $insurance->booking_confirmed ? 'success' : ($insurance->status == 'confirmed' ? 'success' : ($insurance->status == 'pending' ? 'warning' : ($insurance->status == 'active' ? 'info' : 'danger'))) }}">
                                                        {{ $insurance->booking_confirmed ? 'Confirmed' : ucfirst($insurance->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Passengers:</strong></td>
                                                <td class="text-end">
                                                    {{ $insurance->total_adults }} Adult(s)
                                                    @if($insurance->total_children > 0), {{ $insurance->total_children }} Child(ren)@endif
                                                    @if($insurance->total_infants > 0), {{ $insurance->total_infants }} Infant(s)@endif
                                                </td>
                                            </tr>
                                            <tr class="table-success">
                                                <td><strong>Total Premium:</strong></td>
                                                <td class="text-end"><strong style="font-size: 1.2em;">{{ number_format($insurance->total_premium + ($insurance->total_premium * $commissionPercentage), 2) }} {{ $insurance->currency }}</strong></td>
                                            </tr>
                                            @if($insurance->booking_confirmed && $insurance->policy_numbers)
                                            <tr>
                                                <td><strong>Policy Numbers:</strong></td>
                                                <td class="text-end">{{ $insurance->policy_numbers }}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="form-box">
                            <div class="form-box__header">
                                <div class="title">Lead Contact Information</div>
                            </div>
                            <div class="form-box__body">
                                <div class="row mb-3">
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-fields">
                                            <label class="title">Full Name:</label>
                                            <input type="text" class="field" value="{{ $insurance->lead_name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-fields">
                                            <label class="title">Email:</label>
                                            <input type="text" class="field" value="{{ $insurance->lead_email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-fields">
                                            <label class="title">Phone:</label>
                                            <input type="text" class="field" value="{{ $insurance->lead_phone }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-fields">
                                            <label class="title">Country of Residence:</label>
                                            @php
                                                $leadCountry = $insurance->lead_country_of_residence ? \App\Models\Country::where('iso_code', $insurance->lead_country_of_residence)->first() : null;
                                            @endphp
                                            <input type="text" class="field" value="{{ $leadCountry ? $leadCountry->name : ($insurance->lead_country_of_residence ?? 'N/A') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach ($insurance->passengers as $index => $passenger)
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">
                                        Passenger #{{ $index + 1 }}: {{ $passenger->first_name }} {{ $passenger->last_name }}
                                        <span class="badge bg-info ms-2">{{ ucfirst($passenger->passenger_type) }}</span>
                                    </div>
                                </div>
                                <div class="form-box__body">
                                    <div class="row mb-3">
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">First Name:</label>
                                                <input type="text" class="field" value="{{ $passenger->first_name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Last Name:</label>
                                                <input type="text" class="field" value="{{ $passenger->last_name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Gender:</label>
                                                <input type="text" class="field" value="{{ $passenger->gender }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Date of Birth:</label>
                                                <input type="text" class="field" value="{{ formatDate($passenger->date_of_birth) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Age:</label>
                                                <input type="text" class="field" value="{{ $passenger->age ?? 'N/A' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Passport Number:</label>
                                                <input type="text" class="field" value="{{ $passenger->passport_number }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Nationality:</label>
                                                @php
                                                    $nationalityCountry = \App\Models\Country::where('iso_code', $passenger->nationality)->first();
                                                @endphp
                                                <input type="text" class="field" value="{{ $nationalityCountry ? $nationalityCountry->name : $passenger->nationality }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Country of Residence:</label>
                                                @php
                                                    $residenceCountry = \App\Models\Country::where('iso_code', $passenger->country_of_residence)->first();
                                                @endphp
                                                <input type="text" class="field" value="{{ $residenceCountry ? $residenceCountry->name : $passenger->country_of_residence }}" readonly>
                                            </div>
                                        </div>
                                        @if($passenger->policy_number)
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Policy Number:</label>
                                                <input type="text" class="field" value="{{ $passenger->policy_number }}" readonly>
                                            </div>
                                        </div>
                                        @endif
                                        @if($passenger->policy_url_link)
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Policy Document:</label>
                                                <a href="{{ $passenger->policy_url_link }}" target="_blank" class="themeBtn">
                                                    <i class='bx bx-download'></i> Download Policy PDF
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
