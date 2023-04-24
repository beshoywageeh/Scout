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
                    <li class="breadcrumb-item"><a href="{{ route('badge.index') }}"
                                                   class="default-color">الرئيسية</a>
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
    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <a class="button text-bold " href="{{route('badge.create')}}">
                    <i class="ti-plus"></i><strong>أضف</strong>
                </a>
<br>
<br>
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered p-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>القطاع</th>
                            <th>الحالة</th>
                            <th>عملبات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($badges as $badge)

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$badge->name}}</td>
                                <td>{{$badge->department->name}}</td>
                                <td>@if  ($badge->active == 1)
                                        <label class="badge badge-success">مفعل</label>
                                    @else
                                        <label class="badge badge-danger">غير مفعل</label>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group ">
                                        <button type="button" class="btn btn-success btn-sm"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">العمليات
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item" href="#"><i
                                                    class="ti-pencil-alt mr-2 text-warning"></i><strong>تعديل</strong>
                                            </button>
                                            <button class="dropdown-item" data-toggle="modal" data-target="#delete_badge{{$badge->id}}"><i
                                                    class="ti-trash mr-2 text-danger"></i><strong>حذف</strong>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
@include('backend.badges.delete')
                        @empty
                            <div class="col-lg-12">
                                <div class="alert alert-danger">
                                    <h4 class="text-center font_cairo">لا يوجد بيانات للعرض</h4>
                                </div>
                            </div>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
