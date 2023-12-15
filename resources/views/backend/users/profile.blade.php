
@extends('layouts.app')
@section('title')
    ملف شخصي
@endsection
@push('css')
    <style>
#perosna_data{border: 2px solid #ddd}
    </style>
@endpush
@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">{{ $data['user']->first_name . ' ' . $data['user']->second_name }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="default-color">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $data['user']->first_name . ' ' . $data['user']->second_name }}
                    </li>
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
                                @if (is_null($data['user']->image))
                                    <img class='img-fluid w-50 rounded-circle' src="{{ asset('images/login-banner.jpg') }}">
                                @else
                                    <img class='img-fluid w-50 rounded-circle'
                                        src="{{ asset('attachments/users/' . $data['user']->image->filename) }}">
                                @endif
                                <div class="row">
                                    <div class="col">
                                        <a class="btn btn-success" target="_blank"
                                            href="https://wa.me/{{ $data['user']->phone_number }}"><i
                                                class="fa fa-whatsapp fa-2x"></i></a>
                                    </div>
                                    <div class='col'>
                                        <a href="{{ route('user.edit', ['id' => $data['user']->id]) }}"
                                            class="btn btn-warning"><i
                                                class="ti-pencil-alt"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <a class="btn btn-info" href="{{route('pdf.personal.info',['code'=>$data['user']->code])}}" target='_blank' id="button" >تصدير بيانات
                                            شخصية</a>

                                    </div>
                                    <div class="col">{!!$data['user']->archive_check()!!}</div>
                                </div>
                                <div class="table-responsive" id="print">
                                    <table id="data"class="table table-striped table-bordered center p-0">
                                        <tr>
                                            <td colspan="2">الكود</td>
                                            <td colspan="2">{{ $data['user']->code }}</td>
                                        </tr>
                                        <tr>
                                            <td>الاسم</td>
                                            <td>{{ $data['user']->first_name . ' ' . $data['user']->second_name . ' ' . $data['user']->third_name }}
                                            </td>
                                            <td>القطاع</td>
                                            <td>{{ $data['user']->department->name }}</td>

                                        </tr>
                                        <tr>
                                            <td>التليفون</td>
                                            <td>{{ $data['user']->phone_number }}</td>
                                            <td>تليفون المنزل</td>
                                            <td>{{ $data['user']->home_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>العنوان</td>
                                            <td>{{ $data['user']->address }}</td>
                                            <td>أب الاعتراف</td>
                                            <td>{{ $data['user']->church_father }}</td>
                                        </tr>
                                        <tr>
                                            <td>تاريخ الميلاد</td>
                                            <td>{{ $data['user']->birth_date }}</td>
                                            <td>تاريخ الالتحاق</td>
                                            <td>{{ $data['user']->join_date }}</td>
                                        </tr>
                                        <tr>
                                            <td>اجمالي الحضور</td>
                                            <td>{{ \App\Models\attendance::where('user_id', $data['user']->code)->where('status', '1')->count() }}
                                            </td>
                                            <td>اجمالي الشارات</td>
                                            <td>{{ $data['user']->badges_count }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('create.note') }}" method="post" class="bg-secondary p-3">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="user_code" value="{{ $data['user']->code }}">
                                <div class="col-lg-10">
                                    <textarea class="form-control" name="notes" id="" placeholder="اضف ملاحظتك"></textarea>
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="button">أضف</button>
                                </div>
                            </div>

                        </form>
                        <hr>


                        <div class="tab nav-bt">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="home-03-tab" data-toggle="tab" href="#home-03"
                                        role="tab" aria-controls="home-03" aria-selected="true">حضور</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-03-tab" data-toggle="tab" href="#profile-03"
                                        role="tab" aria-controls="profile-03" aria-selected="false">شارات</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes-03" role="tab"
                                        aria-controls="notes-03-tab" aria-selected="false">ملاحظات</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="home-03" role="tabpanel"
                                    aria-labelledby="home-03-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered p-0">
                                            <thead>
                                                <tr>
                                                    <th>التاريخ</th>
                                                    <th>الحالة</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($data['attendance'] as $attendance)
                                                    <tr>
                                                        <td>{{ $attendance->attendance_date }}</td>

                                                        @if ($attendance->status == '1')
                                                            <td class="alert-success">حضور</td>
                                                        @elseif($attendance->status == '2')
                                                            <td class="alert-warning">عذر</td>
                                                        @elseif($attendance->status == '3')
                                                            <td class="alert-danger">غياب</td>
                                                        @else
                                                            <td></td>
                                                        @endif


                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile-03" role="tabpanel" aria-labelledby="profile-03-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered p-0">
                                            <thead>
                                                <tr>
                                                    <th>الشارة</th>
                                                    <th>القطاع</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($data['user']->badges as $badge)
                                                    <tr>
                                                        <td>{{ $badge->name }}</td>
                                                        <td>{{ $badge->department->name }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="notes-03" role="tabpanel" aria-labelledby="notes-03-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered p-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ملاحظات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['user']->notes as $note)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $note->note }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
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
@endsection
@push('script')
    <script>
    </script>
@endpush
