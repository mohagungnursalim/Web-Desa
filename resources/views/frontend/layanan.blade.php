@extends('frontend.layouts.app')

@push('styles')
@livewireStyles
@endpush

@push('scripts')
@livewireScripts
@endpush

@section('title')
Layanan |
@endsection

@section('content')
<section class="content pt-10 lg:pt-10">
    <div>
        {{-- Livewire Component --}}
        @livewire('frontend.layanan.layanan')
    </div>
</section>
@endsection
