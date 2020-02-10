@extends('layouts.auth')

@section('title', page_title(__('Register')))

@section('form')
<form class="card" action="" method="post">
    @csrf
    <div class="card-body p-6">
        <div class="card-title">{{ __('Create new account') }}</div>

        <div class="form-group">
            <label class="form-label" for="name">{{ __('Name') }}</label>
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="{{ __('Please enter your full name') }}">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="{{ __('Please enter your e-mail address') }}">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">
                {{ __('Password') }}
            </label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Please enter your password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">
                {{ __('Confirm Password') }}
            </label>
            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required placeholder="Please confirm your password">

            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-block">Create new account</button>
        </div>
    </div>
</form>
<div class="text-center text-muted">
    Already have account? <a href="{{ route('login') }}">Sign in</a>
</div>
@endsection
