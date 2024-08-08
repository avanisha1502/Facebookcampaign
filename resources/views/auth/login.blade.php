@extends('layouts.app')

@section('content')
    {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
    <div class="login">
        <div class="login-content">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1 class="text-center">{{ __('Login') }}</h1>
                <div class="text-muted text-center mb-4">
                    {{ __('For your protection, please verify your identity.') }}
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email"
                        class="form-control form-control-lg fs-15px @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="d-flex">
                        <label class="form-label">{{ __('Password') }}</label>
                        {{-- <a href="#" class="ms-auto text-muted">{{ __('Forgot password?') }}</a> --}}
                    </div>
                    <input id="password" type="password"
                        class="form-control form-control-lg fs-15px @error('password') is-invalid @enderror" name="password"
                        required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label fw-500" for="customCheck1">{{ __('Remember me') }}</label>

                       @if (Route::has('password.request'))
                            {{-- <div class="text-end text-muted"> --}}
                                <a class="" href="{{ route('password.request') }}" style="margin-left: 86px;">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            {{-- </div> --}}
                        @endif 
                    </div>


                </div>
                <button type="submit" class="btn btn-theme btn-lg d-block w-100 fw-500 mb-3">{{ __('Login') }}</button>

                <div class="text-center text-muted">
                    {{ __('Dont have an account yet?') }} <a href="{{ route('register') }}">{{ __('Sign up') }}</a>.
                </div>
                <div class="mt-3 mb-3" style="text-align: center">{{ __('or sign in with') }}</div>
                <div class="flex items-center justify-end mt-2" style="display: ruby-text; border-radius: 9px;">
                    <div class="btn btn-outline-primary">
                        <a href="{{ route('auth.google') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                                <path d="M1 1h22v22H1z" fill="none" />
                            </svg>
                            {{-- <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"
                                style="border-radius: 9px;"> --}}
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
