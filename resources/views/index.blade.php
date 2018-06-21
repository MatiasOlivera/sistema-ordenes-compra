@extends('layouts.boilerplate')

@section('body')
    <view-login></view-login>
@endsection

@push('scripts')
    <script src="{{ asset('js/index.js') }}" charset="utf-8"></script>
@endpush
