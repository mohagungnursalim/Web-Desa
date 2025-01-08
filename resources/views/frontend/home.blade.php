@extends('frontend.layouts.app')
@push('styles')
@livewireStyles
@endpush
@push('scripts')
@livewireScripts
@endpush

@section('title')
Home | {{ $appName }}
@endsection

@section('content')
<section class="content">
{{-- Livewire Component --}}
@livewire('frontend.home.home')
</section>
@endsection
