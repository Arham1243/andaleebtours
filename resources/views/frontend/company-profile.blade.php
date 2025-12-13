@extends('frontend.layouts.main')
@section('content')
    <section class="section-company-profile mar-y">
        <div class="container">

            <!-- Header & Action -->
            <div class="row justify-content-center text-center mb-3">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-2 px-3 py-2 rounded-pill fw-medium"
                        style="color: var(--color-primary)!important;">
                        <i class='bx bx-file-pdf align-middle me-1'></i> Andaleeb Travel Agency
                    </span>
                    <h2 class="fw-bold mb-3">Company Profile</h2>
                    <p class="text-muted mb-4">
                        Explore our vision, mission, and the services that define Andaleeb Travel Agency.
                        View online or download.
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-11 col-xl-10">
                    <div class="pdf-window-wrapper">
                        <div class="pdf-content">
                            <iframe src="{{ asset('frontend/assets/files/Company-Profile-Andaleeb-Travels.pdf') }}"
                                title="Company Profile" loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
