@extends('layouts.app')

@prepend('js')
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@endprepend

@section('body')
    @routes
    @inertia
@endsection
