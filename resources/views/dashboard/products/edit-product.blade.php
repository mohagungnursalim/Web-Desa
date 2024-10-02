@extends('dashboard.layouts.app')
@push('styles')
@livewireStyles
@endpush
@push('scripts')
@livewireScripts
@endpush

@section('title')
Edit Produk
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@yield('title')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-secondary" href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/dashboard/produk">Produk</a></li>
                    <li class="breadcrumb-item"><a class="text-primary"
                            href="{{ route('dashboard.produk.edit', $product->id) }}">@yield('title')</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    @livewire('dashboard.products.product-edit', ['id' => $product->id])
</section>
@endsection
