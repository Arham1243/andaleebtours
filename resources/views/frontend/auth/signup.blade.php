@extends('frontend.layouts.main')
@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-6 col-xl-5">

                    <div class="auth-card">
                        <div class="auth-header">
                            <h2>Create Account</h2>
                            <p>Start your journey with Andaleeb Travel</p>
                        </div>

                        <form action="#">
                            <!-- Name Fields Row -->
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="custom-input" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="custom-input" required>
                                    </div>
                                </div>
                            </div>

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

                            <!-- Submit -->
                            <button type="submit" class="btn-auth">Sign Up</button>
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
                            Already have an account? <a href="{{ route('frontend.auth.login') }}" class="auth-link">Login</a>
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
