@extends('layouts.app')

@section('content')
    {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
    <div class="register">
        <!-- BEGIN register-content -->
        <div class="register-content">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1 class="text-center">{{ __('Sign Up') }}</h1>
                <p class="text-muted text-center">{{ __('One Admin ID is all you need to access all the Admin services.') }}
                </p>
                <div class="mb-3">
                    <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input id="name" type="text"
                        class="form-control form-control-lg fs-15px @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                    <input id="email" type="email"
                        class="form-control form-control-lg fs-15px @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                    <input id="password" type="password"
                        class="form-control form-control-lg fs-15px  @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                        autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="customCheck1">
                        <label class="form-check-label fw-500" for="customCheck1">{{ __('I have read and agree to the') }}
                            <a href="#">{{ __('Terms of Use') }}</a> {{ __('and') }} <a
                                href="#">{{ __('Privacy Policy') }}</a>.</label>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit"
                        class="btn btn-theme btn-lg fs-15px fw-500 d-block w-100">{{ __('Sign Up') }}</button>
                </div>
                <div class="text-muted text-center">
                    {{ __('Already have an Admin ID?') }} <a href="{{ route('login') }}">{{ __('Sign In') }}</a>
                </div>
            </form>
        </div>
        <!-- END register-content -->
    </div>
@endsection
