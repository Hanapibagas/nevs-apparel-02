<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard | {{ Auth::user()->name }} </title>

    <meta name="description" content="" />

    <link rel="icon" href="/assets/logo.png" type="image/x-icon">

    @stack('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css" rel="stylesheet"> --}}


    @include('includes.style')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('includes.sidebar')

            <div class="layout-page">

                @include('includes.navbar')

                <div class="content-wrapper">

                    @yield('content')

                    <div class="content-backdrop fade"></div>
                </div>

            </div>

        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    @stack('js')

    @include('includes.script')


</body>

</html>
