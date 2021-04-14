<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap4 Dashboard Template">
    <meta name="author" content="ParkerThemes">
    <link rel="shortcut icon" href="{{ admin_asset('') }}/img/fav.png"/>

    <!-- Title -->
    <title>@yield('title','Admin Dashboard')</title>


    <!-- *************
        ************ Common Css Files *************
    ************ -->
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/css/bootstrap.min.css">
    <!-- Icomoon Font Icons css -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/fonts/style.css">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/css/main.css">
    <!-- Chat css -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/css/chat.css">

    <!-- *************
        ************ Vendor Css Files *************
    ************ -->
    @yield('style')
</head>

<body>

<!-- Loading starts -->
<div id="loading-wrapper">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Loading ends -->

<!-- Page wrapper start -->
<div class="page-wrapper">
