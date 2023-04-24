@php use App\Models\attendance; @endphp
@php use App\Models\User; @endphp
@extends('layouts.app')
@section('title')
    لوحة التحكم
@endsection
@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo"> لوحة التحكم</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> لوحة التحكم</li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <!-- Start Widgets -->
    <div class="row">
        <div class="col-12 mb-30 ">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 mt-4 mt-xl-0">
                            <h5 class="card-title">الاعداد - تفاصيل الحضور :
                                <bdi>{{ $data['latest_date'] }}</bdi>
                            </h5>
                            <div class="media">
                                <div class="media-body">
                                    <div class="table-responsive text-center">
                                        <table class="table table-striped table-bordered p-0">
                                            <thead class="alert alert-info">
                                                <tr>
                                                    <th>القطاع</th>
                                                    <th>فعلي</th>
                                                    <th>ارشيف</th>
                                                    <th>حضور</th>
                                                    <th>غياب</th>
                                                    <th>اعتذار</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['department'] as $department)
                                                    <tr>
                                                        <td>
                                                            {{ $department->name }}
                                                        </td>
                                                        <td>
                                                            {{ $department->users_count }}
                                                        </td>
                                                        <td>{{ User::onlyTrashed()->where('department_id', $department->id)->count() }}
                                                        </td>
                                                        <td>{{ attendance::where('department_id', $department->id)->where('attendance_date', $data['latest_date'])->where('status', 1)->count() }}
                                                        </td>
                                                        <td>{{ attendance::where('department_id', $department->id)->where('attendance_date', $data['latest_date'])->where('status', 2)->count() }}
                                                        </td>
                                                        <td>{{ attendance::where('department_id', $department->id)->where('attendance_date', $data['latest_date'])->where('status', 3)->count() }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="alert alert-warning">
                                                <tr>
                                                    <th>أجمالي المجموعة</th>
                                                    <th>{{ User::count() }}</th>
                                                    <th>{{ User::onlyTrashed()->count() }}</th>
                                                    <td>{{ attendance::where('attendance_date', $data['latest_date'])->where('status', 1)->count() }}
                                                    </td>
                                                    <td>{{ attendance::where('attendance_date', $data['latest_date'])->where('status', 2)->count() }}
                                                    </td>
                                                    <td>{{ attendance::where('attendance_date', $data['latest_date'])->where('status', 3)->count() }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Widgets -->
    <!-- Start Widgets -->
    <div class="row">
        <div class="col-12 mb-30 ">

            <div class="card card-statistics h-100">

                <div class="card-body">
                    <h5 class="card-title">أخر عشر حركات
                    </h5>

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="tab nav-bt">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="home-03-tab" data-toggle="tab" href="#home-03"
                                            role="tab" aria-controls="home-03" aria-selected="true"> الافراد</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-03-tab" data-toggle="tab" href="#profile-03"
                                            role="tab" aria-controls="profile-03" aria-selected="false">حضور وغياب</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="home-03" role="tabpanel"
                                        aria-labelledby="home-03-tab">
                                        <div class="table-responsive text-center">
                                            <table class="table table-striped table-bordered p-0">
                                                <thead class="alert alert-info">
                                                    <tr>
                                                        <th>القطاع</th>
                                                        <th>كود</th>
                                                        <th>الاسم</th>
                                                        <th>التليفون</th>
                                                        <th>العنوان</th>
                                                        <th>تاريخ الميلاد</th>
                                                        <th>تليفون البيت</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['users'] as $user)
                                                        <tr>
                                                            <td>
                                                                {{ $user->department->name }}
                                                            </td>
                                                            <td>{{ $user->code }}</td>
                                                            <td>{{ $user->first_name . ' ' . $user->second_name . ' ' . $user->third_name }}
                                                            </td>
                                                            <td>{{ $user->phone_number }}</td>
                                                            <td>{{ $user->address }}</td>
                                                            <td>{{ $user->birth_date }}</td>
                                                            <td>{{ $user->home_number }}</td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="profile-03" role="tabpanel"
                                        aria-labelledby="profile-03-tab">

                                        @if ($data['attendance']->count() == 0)
                                            <div class="alert alert-primary">
                                                <p class="text-white">لا يوجد بيانات للعرض</p>
                                            </div>
                                        @else
                                            <table class="table table-striped table-bordered p-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th>القطاع</th>
                                                        <th>الكود</th>
                                                        <th>الاسم</th>
                                                        <th>{{ $data['attendance']->first() == null ? '-' : $data['attendance']->first()->attendance_date }}
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['attendance'] as $users_data)
                                                        <tr>
                                                            <th>{{ is_null($users_data->users) ? '-' : $users_data->users->department->name }}
                                                            </th>
                                                            <th>{{ is_null($users_data->users) ? '-' : $users_data->users->code }}
                                                            </th>
                                                            <th>{{ is_null($users_data->users) ? '-' : $users_data->users->first_name . ' ' . $users_data->users->second_name . ' ' . $users_data->users->third_name }}
                                                            </th>
                                                            @if ($users_data->status == '1')
                                                                <th class="alert alert-success">حضور</th>
                                                            @elseif($users_data->status == '2')
                                                                <th class="alert alert-danger">غياب</th>
                                                            @else
                                                                <th class="alert alert-warning">اعتذار</th>
                                                            @endif
                                                        </tr>
                                                    @endforeach


                                                </tbody>

                                            </table>
                                        @endif

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Widgets -->
    <!-- Start Widgets -->
    <div class="row">
        <div class="col-12 mb-30 ">

            <div class="card card-statistics h-100">
                <div class="card-body">
                    <h5 class="card-title">الاعداد - تفاصيل الحضور </h5>

                    <div class="accordion plus-icon shadow">
                        @forelse ($data['dates'] as $date)
                            <div class="acd-group">
                                <a href="#" class="acd-heading">الاعداد - تفاصيل الحضور :
                                    <bdi>{{ $date }}</a>
                                <div class="acd-des">
                                    <div class="table-responsive text-center">
                                        <table class="table table-striped table-bordered p-0">
                                            <thead class="alert alert-info">
                                                <tr>
                                                    <th>القطاع</th>
                                                    <th>فعلي</th>
                                                    <th>ارشيف</th>
                                                    <th>حضور</th>
                                                    <th>غياب</th>
                                                    <th>اعتذار</th>
                                                </tr>
                                            </thead>
                                            @foreach ($data['department'] as $department)
                                            <tr>
                                                <td>
                                                    {{ $department->name }}
                                                </td>
                                                <td>
                                                    {{ $department->users_count }}
                                                </td>
                                                <td>{{ User::onlyTrashed()->where('department_id', $department->id)->where('deleted_at','>=',$date)->count() }}
                                                </td>
                                                <td>{{ attendance::where('department_id', $department->id)->where('attendance_date', $date)->where('status', 1)->count() }}
                                                </td>
                                                <td>{{ attendance::where('department_id', $department->id)->where('attendance_date', $date)->where('status', 2)->count() }}
                                                </td>
                                                <td>{{ attendance::where('department_id', $department->id)->where('attendance_date', $date)->where('status', 3)->count() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                            <tfoot class="alert alert-warning">
                                                <tr>
                                                    <th>أجمالي المجموعة</th>
                                                    <th>{{ User::count() }}</th>
                                                    <th>{{ User::onlyTrashed()->where('deleted_at', '>=', $date)->count() }}
                                                    </th>
                                                    <td>{{ attendance::where('attendance_date', $date)->where('status', 1)->count() }}
                                                    </td>
                                                    <td>{{ attendance::where('attendance_date', $date)->where('status', 2)->count() }}
                                                    </td>
                                                    <td>{{ attendance::where('attendance_date', $date)->where('status', 3)->count() }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="acd-des">
                                    <h5 class="alert alert-warning">لايوجد بيانات للعرض</h5>
                                </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>


        <!-- End Widgets -->
    @endsection
    @push('script')
    @endpush
