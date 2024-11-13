@extends('layouts.app')

@section('content')
    <div class="container" style="background-color: #b3cde0; min-height: 100vh;"> <!-- Biru pastel -->
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('admin/img/logo project.png') }}" alt="Login Banner" class="img-fluid">
            </div>
            <div class="col-md-4"> <!-- Adjusted column size -->
                <div class="card shadow-lg" style="border-radius: 10px; padding: 20px; height: 80%;">
                    <!-- Set card height -->
                    <div class="card-header text-center"
                        style="background-color: #6497b1; color: white; font-weight: bold; font-size: 1.25rem;">
                        {{ __('Login to Your Account') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-sm"> <!-- Changed button color -->
                                    {{ __('Login') }}
                                </button>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-center mt-2">
                                    <a class="btn btn-link btn-sm"
                                        href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                </div>
                            @endif

                            <div class="text-center mt-3">
                                <hr>
                                <p style="font-size: 0.9rem;">Or Login with</p> <!-- Adjusted font size -->
                                <a href="#" class="btn btn-outline-secondary btn-sm me-2">Facebook</a>
                                <a href="#" class="btn btn-outline-secondary btn-sm">Google</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
