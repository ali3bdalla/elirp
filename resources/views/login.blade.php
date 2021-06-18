
@extends('_base')

@section('content')
    @inertia
@endsection

@push('css')
    <link href="{{ asset('assets/css/pages/login/classic/login-4.css') }}" rel="stylesheet" type="text/css"></link>
@endpush
@push('js')
    <script src="{{ asset('assets/js/pages/custom/login/login-general.js') }}"></script>
@endpush
