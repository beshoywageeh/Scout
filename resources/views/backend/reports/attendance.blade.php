@php
    use App\Models\department;
    $title = 'تقرير الحضور وغياب';
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
                    <form action="{{ route('reports.attendance.data') }}" method="get" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-2">
                                <select name="department" id="" class="custom-select">
                                    <option value="" selected disabled>اختر القطاع</option>
                                    @foreach ($departments as $department)
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
                            @isset($data)
                                <div class="col-2">
                                    <a type="button" target="_blank" class='button btn-block'
                                        href="{{ route('pdf.attendance_Export_pdf', ['id' => $dep, 'date_from' => $data['from'], 'date_to' => $data['to']]) }}">PDF</a>
                                </div>
                            @endisset
                        </div>
                    </form>
                    @isset($data)
                        <div class='table-responsive mt-10 text-center'>
                            <table class='table table-bordered'>
                                <tr>
                                    <td colspan="6">
                                        <h6>{{ department::where('id', $dep)->pluck('name')->first() }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>حضور</td>
                                    <td>{{ $data['came'] }}</td>
                                    <td>غياب</td>
                                    <td>{{ $data['absent'] }}</td>
                                    <td>اعتذار</td>
                                    <td>{{ $data['else'] }}</td>

                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive mt-10 text-center">
                            <table id="user-table" class="table table-striped table-bordered p-0">



                                    @foreach ($data['attendance'] as $key => $attendance)
                                        <tr>
                                            <table class="table table-bordered text-black table-info p-0">
                                                <tr>
                                                    <th>الكود : {{ $key }}</th>
                                                    <th>الاسم : {{ $attendance[0]->get_full_name($key) }}</th>
                                                </tr>
                                                <tr>
                                                    <table class="table table-striped table-bordered p-0">
                                                        <tr>
                                                            <th>التاريخ</th>
                                                            <th>الحالة</th>
                                                        </tr>
                                                        @foreach ($attendance as $attend)
                                                            <tr>
                                                                <td>{{ $attend->attendance_date }}</td>
                                                                {{ $attend->status_check($attend->status) }}
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </tr>
                                            </table>
                                        </tr>
                                    @endforeach



                            </table>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
