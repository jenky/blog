@extends('layouts.master')

@prepend('css')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endprepend

@section('body')
<div id="app">
    @yield('content')
</div>
@endsection
