@extends('layouts.app')

@section('container')
    <view-actividades></view-actividades>
@endsection

@push('scripts')
    <script src="{{ asset('js/actividades.js') }}"></script>
@endpush