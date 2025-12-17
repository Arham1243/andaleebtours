@extends('frontend.layouts.main')
@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">

                    <div class="card status-card p-4 p-md-5 text-center">

                        <!-- Success Icon -->
                        <div>
                            <div class="status-icon-wrapper success">
                                <i class='bx bxs-check-circle'></i>
                            </div>
                        </div>

                        <!-- Headline -->
                        <h1 class="h3 fw-bold mb-2">Payment Successful!</h1>
                        <p class="text-muted mb-4">
                            Thank you for your booking. A confirmation email has been sent to your inbox.
                        </p>

                        <!-- Transaction Details (The "Receipt") -->
                        <div class="transaction-details mb-4">
                            <div class="detail-row">
                                <span class="text-muted">Transaction ID</span>
                                <span class="fw-medium">#TRX-88592</span>
                            </div>
                            <div class="detail-row">
                                <span class="text-muted">Date</span>
                                <span class="fw-medium">Dec 17, 2025</span>
                            </div>
                            <div class="detail-row total">
                                <span>Amount Paid</span>
                                <span>$249.00</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-primary-theme btn-lg">View My Booking</a>
                            <a href="#" class="btn btn-link text-decoration-none text-muted">Return to Home</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
