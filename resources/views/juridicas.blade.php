@extends('layouts.app')

@section('container')
  <view-juridicas></view-juridicas>
@endsection

@push('scripts')
    <script src="{{ asset('js/juridicas.js') }}" charset="utf-8"></script>
@endpush
