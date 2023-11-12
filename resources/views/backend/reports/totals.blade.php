@php

    $title = 'تقرير الاجمالي';
@endphp
@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@push('css')
<style>
    @media print{
        *{
            text-align: center;
            display: flex;
            align-content: center;
            align-items: center;

        }
    }
</style>
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
                    <form action="{{ route('reports.totals_report') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-2">
                                <select name="department" id="" class="custom-select">
                                    <option value="" selected disabled>اختر القطاع</option>
                                    @foreach ($data['departments'] as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="datepicker-form">
                                    <div class="input-group" data-date-format="yyyy-mm-dd">
                                        <span class="input-group-addon">من تاريخ</span>

                                        <input type="text" class="form-control range-from date-picker-default"
                                            placeholder="تاريخ البداية" name="from">
                                        <span class="input-group-addon">الي تاريخ</span>
                                        <input class="form-control range-to date-picker-default" placeholder="تاريخ النهاية"
                                            type="text" name="to">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="button btn-block">بحث</button>
                            </div>
@isset($data['user'])
<div class="col-2">
                                <a class="button btn-block" href="{{route('pdf.total_report', ['id' => $data['department']->id, 'date_from' => $data['from'], 'date_to' => $data['to']])}}">اطبع</a>
                            </div>
@endisset
                        </div>
                    </form>
                    @isset($data['user'])
                        <div class='container text-center mt-3' id="data_print">
                            <div class="table-responsive">
                                <table class="table table-bordered p-0 ">

                                    <tr>
                                        <td rowspan="3" style='width:25%'>

                                            @if (is_null($data['department']->image))
                                                <img class='img-responsive w-50' src="{{ asset('images/login-banner.jpg') }}">
                                            @else
                                                <img class='img-responsive w-50'
                                                    src="{{ asset('storage/attachments/departments/' . $data['department']->image->filename) }}">
                                            @endif

                                        </td>
                                        <td colspan='6' >{{ $data['department']->name }}</td>
                                        <td rowspan="3" style='width:25%'>
                                            <img class='img-responsive w-50' src="{{ asset('images/login-banner.jpg') }}">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan='2'> من تاريخ :
                                            {{ date($data['from']) }}

                                        </td>
                                        <td colspan='2'> الي تاريخ :
                                            {{ date($data['to']) }}

                                        </td>
                                        <td colspan='2'> تاريخ الطباعه :
                                            {{ date('Y-m-d') }}

                                        </td>

                                    </tr>
                                </table>
                            </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered p-0 ">

                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">الكود</th>
                                            <th rowspan="2">الاسم</th>
                                            <th colspan="3">الحالة</th>
                                        </tr>
                                        <tr>
                                            <th>ح</th>
                                            <th>غ</th>
                                            <th>ع</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['user'] as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->code }}</td>
                                                <td>{{ $user->full_name() }}</td>

                                                {{ $user->count_status($data['from'], $data['to'], $user->code, $user->department_id) }}

                                            </tr>
                                        @endforeach
                                    </tbody>



                                </table>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    function print(){
        var printContents = document.getElementById('data_print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
}
</script>
@endpush
