@extends('layouts.app')
@php
    $title = 'تقرير الغياب';
@endphp
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
                    <form action="{{ route('reports.absent.data.view') }}" method="get" autocomplete="off">
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
                                        href="{{ route('pdf.absent_Export_pdf', ['id' => $data['department']->id, 'date_from' => $data['from'], 'date_to' => $data['to']]) }}">PDF</a>
                                </div>
                            @endisset
                        </div>

                    </form>
                    @isset($data)
                        <hr class="mt-10 mb-10">
                        <div id="print">
                            <table id="user-table" class="table table-striped table-bordered p-0 ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الكود</th>
                                        <th>الاسم</th>
                                        <th>الحالة</th>
                                        <th>التليفون الشخصي</th>
                                        <th>تليفون البيت</th>
                                    </tr>
                                </thead>
                                @foreach ($data['attendance'] as $user_data)
                                    @if (!empty($user_data->users->first_name))
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user_data->users->code }}</td>
                                            <td>{{ $user_data->users->first_name . ' ' . $user_data->users->second_name . ' ' . $user_data->users->third_name }}
                                            </td>
                                            <!--start check Status-->
                                            {{ $user_data->status_check($user_data->status) }}
                                            <!--end check Status-->

                                            <td>{{ $user_data->users->phone_number }}</td>
                                            <td>{{ $user_data->users->home_number }}</td>
                                        </tr>
                                    @else
                                    @endif
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
