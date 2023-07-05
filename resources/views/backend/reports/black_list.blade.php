@extends('layouts.app')
@section('title')
    تقرير البلاك ليست
@endsection
@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">تقرير البلاك ليست</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('department.index') }}" class="default-color">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">تقرير البلاك ليست</li>
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
                    @if($data->count() == 0)

                    <div class="row">
                        <div class="col-12">
                            <h2 class="alert alert-danger text-center">لايوجد بيانات للعرض</h2>
                        </div>
                    </div>
                @else
                <a target="_blank" href="{{route('pdf.blacklist_export')}}"
                        class="button btn-sm">PDF

                    </a>
                    <table class="table table-striped table-bordered p-0 user_table">
                        <thead>
                            <tr>
                                <th colspan="8">بلاك ليست</th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>الفريق</th>
                                <th>الكود</th>
                                <th>الاسم</th>
                                <th>العنوان</th>
                                <th>رقم التليفون</th>
                                <th>تاريخ الاضافة</th>
                                <th>ارجاع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->department->name }}</td>
                                    <td>{{ $user->code }}</td>
                                    <td>{{ $user->first_name . ' ' . $user->second_name . ' ' . $user->third_name }}
                                    </td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ Carbon\Carbon::parse($user->deleted_at)->format('Y-m-d') }}</td>
                                    <td>

                                        <a href="{{ route('user.black_list_restore', ['id' => $user->code]) }}"
                                            class="btn btn-warning btn-sm"><i class='ti-reload mr-2'></i>ارجاع

                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
@push('script')
<script src="{{asset('js/inital_data_table.js')}}"></script>

@endpush
