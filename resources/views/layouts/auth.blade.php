@extends('layouts.app')

@section('content')
<div class="page">
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col col-login mx-auto">
                    <div class="text-center mb-6">
                        {{-- <img src="{{ asset('images/logo.png') }}" class="h-6" alt="{{ config('app.name') }}"> --}}
                    </div>
                    @yield('form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
