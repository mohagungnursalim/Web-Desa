@extends('dashboard.layouts.app')
@push('styles')
@livewireStyles
@endpush
@push('scripts')
@livewireScripts
@endpush

@section('title')
Kelola Akun
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
                    <li class="breadcrumb-item"><a class="text-primary" href="/dashboard/kelola-akun">@yield('title')</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    @livewire('dashboard.users.users')
</section>

@endsection
