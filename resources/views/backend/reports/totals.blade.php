@php

$title = 'تقرير الاجمالي';
@endphp
@extends('layouts.app')
@section('title')
{{ $title }}
@endsection
@push('css')
@endpush
@section('content-header')
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0 font_cairo">{{ $title }}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('department.index') }}" class="default-color">الرئيسية</a>
                </li>
                <li class="breadcrumb-item active">{{ $title }}</li>
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
                <form action="{{ route('pdf.totals_pdf') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <select name="department" id="" class="custom-select">
                                <option value="" selected disabled>اختر القطاع</option>
                                @foreach ($data['department'] as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="datepicker-form">
                                <div class="input-group" data-date-format="yyyy-mm-dd">
                                    <span class="input-group-addon">من تاريخ</span>

                                    <input type="text" class="form-control range-from date-picker-default" placeholder="تاريخ البداية" name="from">
                                    <span class="input-group-addon">الي تاريخ</span>
                                    <input class="form-control range-to date-picker-default" placeholder="تاريخ النهاية" type="text" name="to">
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="submit" class="button btn-block">بحث</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
@endpush
