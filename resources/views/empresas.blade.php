@extends('layouts.app')

@section('container')
    <view-empresas></view-empresas>
@endsection

@push('scripts')
    <script src="{{ asset('js/empresas.js') }}" charset="utf-8"></script>
@endpush
