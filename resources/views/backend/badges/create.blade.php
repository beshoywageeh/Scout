@extends('layouts.app')
@section('title')
    شارات
@endsection
@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">شارات</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('badge.index') }}" class="default-color">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">شارات</li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @include('backend.msg')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <form class=" row mb-30" action="{{ route('badge.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="repeater">
                                <div data-repeater-list="List_badges">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="col">
                                                <label for="department" class="mr-sm-2">القطاع</label>
                                                <div class="box">
                                                    <select class="form-control" name="department" required>
                                                        <option value="">-- اختار من القائمة --</option>
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}">{{ $department->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label for="name" class="mr-sm-2">الاسم</label>
                                                <div class="box">
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="active"
                                                           id="gridRadios1" value="active">
                                                    <label class="form-check-label" for="gridRadios1">
                                                        تفعيل
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label for="Name_en" class="mr-sm-2">حذف</label>
                                                <input class="btn btn-danger btn-block" data-repeater-delete type="button"
                                                       value="حذف" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-12">
                                        <input class="button small" data-repeater-create type="button" value="اداراج جديد" />
                                    </div>
                                </div><br>
                                <button type="submit" class="btn btn-primary">تاكيد البيانات</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
