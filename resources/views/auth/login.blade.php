@extends('layouts.auth')

@section('title', page_title(__('Login')))

@section('form')
<form method="POST" action="{{ route('login') }}" class="card">
    @csrf
    <div class="card-body p-6">
        <div class="card-title">Login to your account</div>

        <div class="form-group">
            <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">
                {{ __('Password') }}
                {{-- <a href="./forgot-password.html" class="float-right small">I forgot password</a> --}}
            </label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" value="1" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="custom-control-label">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Sign in') }}</button>
        </div>
    </div>
</form>
<div class="text-center text-muted">
    {{ __('Don\'t have account yet?') }} <a href="{{ route('register') }}">{{ __('Sign up') }}</a>
</div>
@endsection
