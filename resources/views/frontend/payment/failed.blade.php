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
                        <h1 class="h3 fw-bold mb-2">Payment Failed</h1>
                        <p class="text-muted mb-4">
                            We couldn't process your payment. Your card has not been charged.
                        </p>

                        <!-- Error Alert Box -->
                        <div class="alert alert-danger border-0 bg-opacity-10 mb-4" role="alert">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class='bx bx-info-circle'></i>
                                <span class="small fw-medium">Error Code: Insufficient Funds (204)</span>
                            </div>
                        </div>

                        <!-- Helpful Suggestions -->
                        <p class="small text-muted mb-4">
                            Please check your card details, ensure you have sufficient funds, or try a different payment
                            method.
                        </p>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-primary-theme btn-lg">Contact Support</a>
                            <a href="#" class="btn btn-link text-decoration-none text-muted">Return to Home</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
