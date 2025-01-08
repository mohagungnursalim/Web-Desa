@extends('frontend.layouts.app')

@push('styles')
@livewireStyles
@endpush

@push('scripts')
@livewireScripts
@endpush

@section('title')
Berita | {{ $post->title }}
@endsection

@section('content')
<section class="content pt-10 lg:pt-10">
    <div>
        {{-- Livewire Component --}}
        @livewire('frontend.berita.berita-detail', ['slug' => $post->slug])
    </div>
</section>
@endsection
