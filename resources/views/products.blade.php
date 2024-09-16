@extends('layouts.app')
@push('styles')
    @livewireStyles
@endpush
@push('scripts')
    @livewireScripts
@endpush

@section('title')
    Produk
@endsection

@section('content')
    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="/dashboard/products">@yield('title')</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

        <div class="container-fluid">
                @livewire('product-table')
        </div>
        <!-- #/ container -->
    </div>
@endsection