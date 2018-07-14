@extends('layouts.app')

@section('container')
    <view-tipos-organizacion></view-tipos-organizacion>
@endsection

@push('scripts')
    <script src="{{ asset('js/tipos_organizacion.js') }}"></script>
@endpush