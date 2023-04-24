<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Elsafina_Scout" />
    <meta name="description" content="Scout System" />
    <meta name="author" content="Bishoy Wageeh" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>@yield('title')</title>
@include('layouts.header_css')
</head>

<body>
<div class="wrapper">
    <!--=================================
preloader -->
    <div id="pre-loader">
        <img src="{{URL::asset('images/pre-loader/loader-01.svg')}}" alt="">
    </div>
    <!--=================================
preloader -->
    <!--=================================
@include('layouts.header')
  <!--=================================
Main content -->
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')

            <!--=================================
Main content -->
            <!--=================================
wrapper -->
            <div class="content-wrapper">
            @yield('content-header')
         @yield('content')
            <!-- main content wrapper end-->
            @include('layouts.footer')
            </div>
        </div>
    </div>
</div>
<!--=================================
footer -->
@include('layouts.footer_script')
</body>

</html>
