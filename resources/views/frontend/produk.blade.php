@extends('frontend.layouts.app')

@push('styles')
@livewireStyles
@endpush

@push('scripts')
@livewireScripts
@endpush

@section('title')
Produk |
@endsection

@section('content')
<section class="content pt-10 lg:pt-10">
    <div>
        {{-- Livewire Component --}}
        @livewire('frontend.product.product')
    </div>
</section>
@endsection
