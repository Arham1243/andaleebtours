@extends('frontend.layouts.main')
@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                    <div class="auth-card">
                        <div class="auth-header">
                            <h2>Welcome Back</h2>
                            <p>Login to access your bookings and profile</p>
                        </div>

                        <form action="#">
                            <!-- Email Field -->
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="custom-input" required>
                            </div>

                            <!-- Password Field with Toggle -->
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <div class="password-wrapper">
                                    <input type="password" class="custom-input password-field" required>
                                    <i class='bx bx-show password-toggle'></i>
                                </div>
                            </div>

                            <!-- Remember & Forgot -->
                            <div class="auth-actions">
                                <label class="custom-checkbox">
                                    <input type="checkbox">
                                    Remember me
                                </label>
                                <a href="{{ route('frontend.auth.password.forgot') }}" class="auth-link">Forgot
                                    Password?</a>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn-auth">Login</button>
                        </form>

                        <!-- Divider -->
                        <div class="auth-divider">
                            <span>OR</span>
                        </div>

                        <!-- Google Button -->
                        <button class="btn-google">
                            <img src="{{ asset('frontend/assets/images/google.svg') }}" alt="Google Logo">
                            Continue with Google
                        </button>

                        <!-- Footer -->
                        <div class="auth-footer">
                            Don't have an account? <a href="{{ route('frontend.auth.signup') }}" class="auth-link">Sign
                                Up</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all toggle icons
            const toggleIcons = document.querySelectorAll('.password-toggle');

            toggleIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    // Find the input within the same wrapper
                    const input = this.previousElementSibling;

                    if (input.type === 'password') {
                        // Switch to text
                        input.type = 'text';
                        // Change icon to hide eye
                        this.classList.remove('bx-show');
                        this.classList.add('bx-hide');
                    } else {
                        // Switch back to password
                        input.type = 'password';
                        // Change icon back to show eye
                        this.classList.remove('bx-hide');
                        this.classList.add('bx-show');
                    }
                });
            });
        });
    </script>
@endpush
