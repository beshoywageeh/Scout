<!DOCTYPE html>
<html lang="ar" dir="rtl">
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
        <img src="images/pre-loader/loader-01.svg" alt="">
    </div>

    <!--=================================
     preloader -->

    @yield('content')

</div>



@include('layouts.footer_script')
</body>
</html>
