@extends('frontend.layouts.main')
@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">

                    <div class="card status-card p-4 p-md-5 text-center">

                        <!-- Error Icon -->
                        <div>
                            <div class="status-icon-wrapper error">
                                <i class='bx bxs-error-circle'></i>
                            </div>
                        </div>

                        <!-- Headline -->
                        @if (session('error_title'))
                            <h1 class="h3 fw-bold mb-2">
                                {{ session('error_title') }}
                            </h1>
                        @endif
                        @if (session('error_description'))
                            <p class="text-muted mb-4">
                                {{ session('error_description') }}
                            </p>
                        @endif

                        <!-- Error Alert Box -->
                        @if (session('error_message'))
                            <div class="alert alert-danger border-0 bg-opacity-10 mb-4" role="alert">
                                <div class="d-flex align-items-start gap-2">
                                    <i class='bx bx-error-circle mt-1'></i>
                                    <div class="text-start">
                                        <strong class="small">{{ session('error_message') }}</strong>   
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Helpful Suggestions -->
                        <p class="small text-muted mb-4">
                            Please try again or contact our support team if the issue persists.
                        </p>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('frontend.checkout.index') }}" class="btn btn-primary-theme btn-lg">Try
                                Again</a>
                            <a href="{{ route('frontend.index') }}"
                                class="btn btn-link text-decoration-none text-muted">Return to Home</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
