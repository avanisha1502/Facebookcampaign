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
                <div class="flex items-center justify-end mt-2 d-flex justify-content-center"
                    style="border-radius: 9px; gap:10px;">
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
                        </a>
                    </div>
                    <div class="btn btn-outline-primary">
                        <a href="{{ route('auth.facebook') }}">
                            <svg height="27" viewBox="0 0 152 164" width="25" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                <radialGradient id="radial-gradient" cx="76" cy="76"
                                    gradientUnits="userSpaceOnUse" r="76">
                                    <stop offset="0" stop-color="#42a5f5" />
                                    <stop offset="1" stop-color="#1565c0" />
                                </radialGradient>
                                <g id="Layer_2" data-name="Layer 2">
                                    <g id="Circle">
                                        <g id="_01._Facebook" data-name="01. Facebook">
                                            <rect id="Background" fill="url(#radial-gradient)" height="152" rx="76"
                                                width="152" />
                                            <g fill="#fff">
                                                <path id="Shade"
                                                    d="m133.2 26c-11.08 20.34-26.75 41.32-46.33 60.9s-40.56 35.22-60.87 46.3q-1.91-1.66-3.71-3.46a76 76 0 1 1 107.45-107.48q1.8 1.8 3.46 3.74z"
                                                    opacity=".1" />
                                                <path id="Icon"
                                                    d="m66.44 81.17h-9.94c-1.57 0-2.12-.57-2.12-2.14q0-6.06 0-12.13c0-1.56.59-2.15 2.13-2.15h9.93v-8.75a21.89 21.89 0 0 1 2.73-11.26 16.51 16.51 0 0 1 8.93-7.42 21.91 21.91 0 0 1 7.65-1.32h9.83c1.41 0 2 .62 2 2v11.41c0 1.43-.6 2-2 2-2.69 0-5.38 0-8.06.11s-4.14 1.33-4.14 4.13c-.06 3 0 5.94 0 9h11.55c1.64 0 2.2.56 2.2 2.21q0 6 0 12.06c0 1.63-.52 2.15-2.17 2.15h-11.64v32.54c0 1.74-.55 2.29-2.26 2.29h-12.52c-1.51 0-2.1-.59-2.1-2.1z" />
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
