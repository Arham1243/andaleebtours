@extends('frontend.layouts.main')
@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                    <div class="auth-card">
                        <div class="auth-header">
                            <h2>Forgot Password?</h2>
                            <p>Enter your email and we'll send you a reset link</p>
                        </div>

                        <form action="#">
                            <!-- Email Field -->
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="custom-input" required>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn-auth">Send Reset Link</button>
                        </form>

                        <!-- Footer -->
                        <div class="auth-footer">
                            <a href="{{ route('frontend.auth.login') }}" class="auth-link"> <i class='bx bx-arrow-back'></i>
                                Back to Login</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
