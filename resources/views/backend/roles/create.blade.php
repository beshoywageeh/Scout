@extends('layouts.app')
@section('title')
    الصلاحيات
@endsection
@push('css')
    <style>
        #user-table > thead > tr > th {
            text-align: center !important;
        }

    </style>
@endpush
@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">الصلاحيات</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}"
                                                   class="default-color">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">الصلاحيات</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('backend.msg')
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">

                <div class="card-body">
                    <form action="{{route('roles.store')}}" method="post">

@csrf
                        <div class="form-group">
                            <strong>الاسم</strong>
                            <input type="text" name="name" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <strong>الصلاحيات</strong>
                            <br/>
                            @foreach($permission as $value)

                                <div class="form-check mb-3">
                                    <input type="checkbox" name="permission[]" value="{{$value->id}}" id=""
                                           class="form-check-input">
                                    <label for="" class="form-check-label">    {{ $value->name }}
                                    </label>
                                </div>

                            @endforeach
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>

    </form>
        </div>
    </div>
        </div>
    </div>

@endsection
