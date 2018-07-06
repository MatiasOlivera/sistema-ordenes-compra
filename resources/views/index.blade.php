@extends('layouts.boilerplate')

@section('body')
    <main id="main">
        <view-login></view-login>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/index.js') }}" charset="utf-8"></script>
@endpush
