@extends('layouts.app')
@section('title')
    القطاعات
@endsection
@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">القطاعات</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('department.index') }}" class="default-color">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">القطاعات</li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @include('backend.msg')
    @include('backend.departments.create')
    <div class="row">
        <div class="col-xl-12 mb-30">
            @can('اضافة قطاع')
                <button class="button text-bold mb-10" data-toggle="modal" data-target="#create_department">
                    <i class="ti-plus"></i><strong>أضف</strong>
                </button>
            @endcan
        </div>

        @forelse ($data['departments'] as $department)
            <div class="col-lg-4 mb-30">
                <div class="card card-statistics h-100">
                    <div class="p-4 text-center text-black">
                        <h5 class="mb-20 text-black font_cairo">{{ $department->name }}</h5>
                        <!-- action group -->
                        <div class="btn-group info-drop">
                            <button type="button" class="dropdown-toggle-split text-black" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="ti-more"></i>
                            </button>
                            <div class="dropdown-menu">

                                <a class="dropdown-item"
                                    href="{{ route('department.profile', ['id' => $department->id]) }}"><i
                                        class="ti-info mr-2 text-primary"></i><strong>تفاصيل</strong>
                                </a>
                                @can('تعديل قطاع')
                                    <button class="dropdown-item" data-toggle="modal"
                                        data-target="#edit_department{{ $department->id }}"><i
                                            class="ti-pencil-alt mr-2 text-warning"></i><strong>تعديل</strong>
                                    </button>
                                @endcan
                                @can('حذف قطاع')
                                    <button class="dropdown-item" data-toggle="modal"
                                        data-target="#delete_department{{ $department->id }}"><i
                                            class="ti-trash mr-2 text-danger"></i><strong>حذف</strong>
                                    </button>
                                @endcan
                                <a href="{{route('attendance.create',$department->id)}}"class="dropdown-item"><i
                                    class="ti-calendar mr-2 text-success"></i><strong> تسجيل الحضور</strong></a>
                                <a
                                    href="{{ route('department.export.data', ['department_id' => $department->id]) }}"class="dropdown-item"><i
                                        class="ti-download mr-2 text-success"></i><strong>تصدير إكسيل</strong></a>
                                <a
                                    href="{{ route('pdf.department_Export_pdf', ['id' => $department->id]) }}" target="_blank"class="dropdown-item"><i
                                        class="ti-file mr-2 text-success"></i><strong>تصدير PDF</strong></a>
                                        <a class="dropdown-item"
                                        href="{{ route('pdf.follow_up', ['department_id' => $department->id]) }}"><i
                                            class="ti-info mr-2 text-primary"></i><strong>تصدير كروت المتابعه</strong>
                                    </a>
                            </div>
                        </div>

                        @if (is_null($department->image))
                            <img class='img-fluid w-50 rounded-circle' src="{{asset('images/login-banner.jpg')}}">
                        @else
                            <img class='img-fluid w-50 rounded-circle'
                                src="{{ asset('storage/attachments/departments/' . $department->image->filename) }}">
                        @endif
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-6 col-sm-4 xs-mb-10 md-mt-0 mt-10">
                                <b>الاجمالي</b>
                                <h4 class="mt-10"> {{ $department->users_count }}</h4>
                            </div>
                            <div class="col-6 col-sm-4 xs-mb-10 md-mt-0 mt-10">
                                <b>حضور </b>
                                @php
                                    $max = \App\Models\attendance::max('attendance_date');
                                    $att = \App\Models\attendance::where('department_id', $department->id)
                                        ->where('attendance_date', $max)
                                        ->where('status', 1)
                                        ->count();

                                @endphp
                                <h4 class="mt-10">{{ $att }}</h4>
                            </div>
                            <div class="col-12 col-sm-4 md-mt-0 mt-10">
                                <b>أرشيف</b>
                                <h4 class="mt-10">
                                    {{ \App\Models\User::onlyTrashed()->where('department_id', $department->id)->count() }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('backend.departments.delete')
            @include('backend.departments.edit')
        @empty
            <div class="col-lg-12">
                <div class="alert alert-danger">
                    <h4 class="text-center font_cairo">لا يوجد بيانات للعرض</h4>
                </div>
            </div>
        @endforelse
    </div>
@endsection
@push('script')
    <script>
        function showPreview(event) {
            if (event.target.files.length > 0) {
                let src = URL.createObjectURL(event.target.files[0]),
                    preview = document.getElementById("preview");
                preview.src = "";
                preview.src = src;
            }
        }
    </script>
@endpush
