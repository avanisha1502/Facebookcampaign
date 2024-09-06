@extends('layouts.app')

@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="login">
        <!-- BEGIN login-content -->
        <div class="login-content">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <h1 class="text-center">{{ __('Reset Password') }}</h1>
                <div class="text-muted text-center mb-4">
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
                <button type="submit" class="btn btn-theme btn-lg d-block w-100 fw-500 mb-3 btn btn-primary">  {{ __('Send Password Reset Link') }}</button>
                <div class="text-center text-muted">
                    {{ __('Forget it Send me back') }} <a href="{{ route('login') }}">{{ __('Login') }}</a>.
                </div>
            </form>
        </div>
        <!-- END login-content -->
    </div>
@endsection
