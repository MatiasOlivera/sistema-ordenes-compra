@extends('layouts.app')

@section('container')
    <view-rubros></view-rubros>
@endsection

@push('scripts')
    <script src="{{ asset('js/rubros.js') }}"></script>
@endpush