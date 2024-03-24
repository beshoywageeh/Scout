@php use App\Models\User; @endphp
@php use App\Models\attendance; @endphp
@php use Carbon\Carbon; @endphp
@extends('layouts.app')
@section('title')
    تفاصيل قطاع : {{$data['department']->name}}
@endsection
@push('css')
@endpush
@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">{{$data['department']->name}}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('department.index') }}"
                                                   class="default-color">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">{{$data['department']->name}}</li>
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
                    <div class="p-4 text-center text-black">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mb-20 text-black font_cairo">{{ $data['department']->name }}</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <span>اجمالي</span>
                                        <h5 class="mb-20 text-black font_cairo">{{ $data['department']->users->count() }}</h5>

                                    </div>
                                    <div class="col-lg-4">
                                        <span>ارشيف</span>
                                        <h5 class="mb-20 text-black font_cairo">{{ User::onlyTrashed()->where('department_id',$data['department']->id)->count() }}</h5>

                                    </div>
                                    <div class="col-lg-4">
                                        <span>حضور</span>
                                        @php
                                            $latest_date=  attendance::latest('attendance_date')->pluck('attendance_date')->first();
                                        @endphp
                                        <h5 class="mb-20 text-black font_cairo">{{ attendance::where('department_id',$data['department']->id)->where('attendance_date',$latest_date)->where('status','1')->count() }}</h5>

                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                @if (is_null($data['department']->image))
                                    <img class='img-fluid w-50 rounded-circle'
                                         src="{{asset('images/login-banner.jpg')}}">
                                @else
                                    <img class='img-fluid w-50 rounded-circle'
                                         src="{{ asset('storage/attachments/departments/' . $data['department']->image->filename) }}">
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="tab nav-bt">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="home-03-tab" data-toggle="tab" href="#home-03"
                                       role="tab" aria-controls="home-03" aria-selected="true">بيانات الافراد</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-03-tab" data-toggle="tab" href="#profile-03"
                                       role="tab" aria-controls="profile-03" aria-selected="false">حضور وغياب</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="portfolio-03-tab" data-toggle="tab" href="#portfolio-03"
                                       role="tab" aria-controls="portfolio-03" aria-selected="false">ارشيف </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="home-03" role="tabpanel"
                                     aria-labelledby="home-03-tab">
                                    @if($data['department']->users->count() != 0)
                                        <div class="mb-10">
                                            <a type="button" class='button' target="_blank"
                                               href="{{route('pdf.department_Export_pdf',['id'=>$data['department']->id])}}">PDF</a>

                                        </div>
                                    @endif

                                    <div id="print">

                                        <div class="table-responsive">
                                            @if($data['department']->users->count()==0)
                                                <div class="alert alert-primary">
                                                    <p class="text-white">لا يوجد بيانات للعرض</p>
                                                </div>
                                            @else
                                                <table class="table table-striped table-bordered p-0 user_table">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>كود</th>
                                                        <th>الاسم</th>
                                                        <th>العنوان</th>
                                                        <th>رقم التليفون</th>
                                                        <th style="width:10%">تاريخ الميلاد</th>
                                                        <th>تليفون البيت</th>
                                                        <th>اب الاعتراف</th>
                                                        <th>تاريخ الاشتراك</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($data['department']->users as $user)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $user->code }}</td>
                                                            <td>{{ $user->full_name()  }}</td>
                                                            <td>{{ $user->address }}</td>
                                                            <td>{{ $user->phone_number }}</td>
                                                            <td>{{$user->birth_date}}</td>
                                                            <td>{{$user->home_number}}</td>
                                                            <td>{{$user->church_father}}</td>
                                                            <td>{{$user->join_date}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile-03" role="tabpanel"
                                     aria-labelledby="profile-03-tab">
                                    <div class="table-responsive">
                                        @if($data['attendance']->count()==0)
                                            <div class="alert alert-primary">
                                                <p class="text-white">لا يوجد بيانات للعرض</p>
                                            </div>
                                        @else

                                            <table class="table table-striped table-bordered p-0 user_table">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>الكود</th>
                                                    <th>الاسم</th>
                                                    <th>{{($data['attendance']->first() == null)?'-':$data['attendance']->first()->attendance_date}}</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data['attendance'] as $users_data)

                                                    <tr>
                                                           <th>{{$loop->iteration}}</th>
                                                           <th>{{(is_null($users_data->users))?'-':$users_data->users->code }}</th>
                                                        <th>{{(is_null($users_data->users))?'-':$users_data->users->full_name() }}</th>
                                                        @if($users_data->status =='1')
                                                            <th class="alert alert-success">ح</th>
                                                        @elseif($users_data->status =='2')
                                                            <th class="alert alert-danger">غ</th>

                                                        @else
                                                            <th class="alert alert-warning">ع</th>

                                                        @endif
                                                    </tr>
                                                @endforeach


                                                </tbody>

                                            </table>
                                        @endif

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="portfolio-03" role="tabpanel"
                                     aria-labelledby="portfolio-03-tab">
                                    <div class="table-responsive">
                                        @if($users->count() > 0)
                                            <table class="table table-striped table-bordered p-0 user_table">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>كود</th>

                                                    <th>الاسم</th>
                                                    <th>العنوان</th>
                                                    <th>رقم التليفون</th>
                                                    <th>تاريخ الميلاد</th>
                                                    <th>تليفون البيت</th>
                                                    <th>اب الاعتراف</th>
                                                    <th>تاريخ الاشتراك</th>
                                                    <th>تاريخ الارشفة</th>
                                                    <th>عمليات</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($users as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data->code }}</td>

                                                        <td>{{ $data->full_name() }}</td>
                                                        <td>{{ $data->address }}</td>
                                                        <td>{{ $data->phone_number }}</td>
                                                        <td>{{$data->birth_date}}</td>
                                                        <td>{{$data->home_number}}</td>
                                                        <td>{{$data->church_father}}</td>
                                                        <td>{{$data->join_date}}</td>
                                                        <td>{{Carbon::parse($data->deleted_at)->format('Y-m-d')}}</td>
                                                        <td>
                                                            <button  href='{{ route('user.restore') }}'title="ارجاع"
                                                                class='btn btn-danger restore'data-toggle="modal"
                                                                data-target="#restore_user"
                                                                data-user_code="{{ $data->code }}"
                                                                data-user_name="{{ $data->full_name() }}">
                                                                <i class='ti-reload'></i>
                                                                </button>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        @else
                                            <div class="alert alert-primary">
                                                <p class="text-white">لا يوجد ارشيف</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
@include('backend.departments.restore')
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
<script src="{{asset('js/inital_data_table.js')}}"></script>

<script>
    $('#restore_user').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var user_code = button.data('user_code')
        var user_name = button.data('user_name')
        var modal = $(this)
        modal.find('.modal-body #user_code').val(user_code);
        modal.find('.modal-body #user_name').val(user_name);
    })
</script>
@endpush
