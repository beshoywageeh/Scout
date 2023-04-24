@extends('layouts.app_login')
@section('title')
    تسجيل الدخول
@endsection

@section('content')
    <section class="height-100vh d-flex align-items-center page-section-ptb login"
             style="background-image: url(images/bg-login.jpg);">
        <div class="container">
            <div class="row justify-content-center no-gutters vertical-align">
                <div class="col-lg-4 col-md-6 login-fancy-bg bg"
                     style="background-image: url(images/login-banner.jpg);">

                </div>
                <div class="col-lg-4 col-md-6 bg-white">
                    <form action="{{route('login')}}" method="post">
                        @csrf
                        <div class="login-fancy pb-40 clearfix">
                            @include('backend.msg')
                            <h3 class="mb-30">تسجيل الدخول</h3>
                            <div class="section-field mb-20">
                                <label class="mb-10" for="name">رقم الهاتف</label>
                                <input id="name" class="web form-control verifed @error('phone_number') is-invalid @enderror"
                                       type="text" placeholder="رقم الهاتف" name="phone_number">
                                @error('phone_number')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="section-field mb-20">
                                <label class="mb-10" for="Password">كلمة المرور </label>
                                <input id="Password" class="Password form-control" type="password"
                                       placeholder="كلمة المرور" name="password">
                            </div>
                            <button id="submit" class="button" type="submit"><span>دخول</span>
                                <i class="fa fa-check"></i></button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
