@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.package-inquiries.show', $packageInquiry) }}
            <div class="custom-sec custom-sec--form">
                <div class="custom-sec__header">
                    <div class="section-content">
                        <h3 class="heading">{{ $title }}</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="form-wrapper">
                        <div class="form-box">
                            <div class="form-box__header">
                                <div class="title">Inquiry Information</div>
                            </div>
                            <div class="form-box__body">
                                <div class="form-fields">
                                    <label class="title">Name</label>
                                    <input type="text" class="field" value="{{ $packageInquiry->name }}" readonly>
                                </div>

                                <div class="form-fields">
                                    <label class="title">Email</label>
                                    <input type="text" class="field" value="{{ $packageInquiry->email }}" readonly>
                                </div>

                                <div class="form-fields">
                                    <label class="title">Phone</label>
                                    <input type="text" class="field" value="{{ $packageInquiry->phone }}" readonly>
                                </div>

                                <div class="form-fields">
                                    <label class="title">Tour Date</label>
                                    <input type="text" class="field" value="{{ $packageInquiry->tour_date ? date('d M Y', strtotime($packageInquiry->tour_date)) : 'N/A' }}" readonly>
                                </div>

                                <div class="form-fields">
                                    <label class="title">Number of Passengers (PAX)</label>
                                    <input type="text" class="field" value="{{ $packageInquiry->pax ?? 'N/A' }}" readonly>
                                </div>

                                <div class="form-fields">
                                    <label class="title">Pickup Location</label>
                                    <input type="text" class="field" value="{{ $packageInquiry->pickup_location ?? 'N/A' }}" readonly>
                                </div>

                                <div class="form-fields">
                                    <label class="title">Message</label>
                                    <textarea class="field" rows="4" readonly>{{ $packageInquiry->message ?? 'N/A' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="seo-wrapper">
                        <div class="form-box">
                            <div class="form-box__header">
                                <div class="title">Package Details</div>
                            </div>
                            <div class="form-box__body">
                                <div class="form-fields">
                                    <label class="title">Package Name</label>
                                    <input type="text" class="field" value="{{ $packageInquiry->package->name ?? 'N/A' }}" readonly>
                                </div>

                                <div class="form-fields">
                                    <label class="title">Category</label>
                                    <input type="text" class="field" value="{{ $packageInquiry->package->category->name ?? 'N/A' }}" readonly>
                                </div>

                                <div class="form-fields">
                                    <label class="title">Package Price</label>
                                    <input type="text" class="field" value="{{ $packageInquiry->package->price ? 'AED ' . number_format($packageInquiry->package->price, 2) : 'N/A' }}" readonly>
                                </div>

                                <div class="form-fields">
                                    <label class="title">Inquiry Date</label>
                                    <input type="text" class="field" value="{{ formatDateTime($packageInquiry->created_at) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-box text-end">
                            <a href="{{ route('admin.package-inquiries.index') }}" class="themeBtn">Go Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
