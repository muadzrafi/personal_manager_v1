<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', 'Dashboard') — Personal Manager</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stack('styles')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

@include('layouts.partials._navbar')
@include('layouts.partials._sidebar')

<div class="content-wrapper">
    <!-- <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('page-title', '')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.dashboard') }}">Home</a>
                        </li>
                        @yield('breadcrumbs')
                    </ol>
                </div>
            </div>
        </div>
    </div> -->

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
            @endif

            @yield('content')

        </div>
    </section>
</div>

@include('layouts.partials._footer')

</div> 

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            // Memaksa AdminLTE dan OverlayScrollbars menghitung ulang layout
            window.dispatchEvent(new Event('resize'));
        }, 100); // Jeda 100ms memastikan DOM sudah selesai dirender
    });
</script>

@stack('scripts')
</body>
</html>