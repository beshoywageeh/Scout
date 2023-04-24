@extends('layouts.app')
@section('title')
    تقرير اعياد الميلاد
@endsection
@push('css')
    <style>
        #printing {
            display: none;
            width: 100%;
        }

        @media print {
            #printing {
                display: block;
                width: 100%;
                text-align: center;
            }

            #print {
                width: 100%
            }
        }
    </style>
@endpush
@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">تقرير اعياد الميلاد</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('department.index') }}"
                                                   class="default-color">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">تقرير اعياد الميلاد</li>
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
                    <form action="{{route('reports.birthday')}}" method="get" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-2">
                                <select name="month" id="" class="custom-select">
                                    <option value="" selected disabled>اختر الشهر</option>
                                        <option value="1">يناير</option>
                                        <option value="2">فبراير</option>
                                        <option value="3">مارس</option>
                                        <option value="4">ابريل</option>
                                        <option value="5">مايو</option>
                                        <option value="6">يونيو</option>
                                        <option value="7">يوليو</option>
                                        <option value="8">أغسطس</option>
                                        <option value="9">سبتمبر</option>
                                        <option value="10">اكتوبر</option>

                                        <option value="11">نوفمبر</option>
                                        <option value="12">ديسمبر</option>
                                </select>
                            </div>
                            <div class="col-2">
                                @php
                                    $departments = \App\Models\department::get()->pluck('id','name');
                                @endphp
                                <select name="department" class ='custom-select' id="">
                                    <option value="" selected>اختر الفريق</option>
                                    @foreach ($departments as $key => $value)
                                        <option value="{{ $value }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="button">بحث</button>
                            </div>
                        </div>

                    </form>
                    @isset($data)
                        <hr class="mt-10 mb-10">
                        <div class="mb-10">
                            <button type="button" class='button' onclick="printdoc()">طباعه</button>

                        </div>
                        <div id="print">
                            <div class="table-responsive mt-10 text-center">
                                <table id="user-table" class="table table-striped table-bordered p-0">
                                    <thead>

                                    <tr>
<th>#</th>
<th>كود</th>
<th>الاسم</th>
<th>الفريق</th>
<th>تاريخ الميلاد</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data['users'] as  $user )


                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$user->code}}</td>
                                                <td>{{$user->first_name.' '.$user->second_name.' '.$user->third_name}}</td>
          <td>{{ \App\Models\department::where('id',$user->department_id)->pluck('name')->first() }}</td>
          <td>{{ $user->birth_date }}</td>
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
        function printdoc() {
            let print_area = document.querySelector("#print").innerHTML,
                original = document.body.innerHTML;
            document.body.innerHTML = print_area;
            window.print();
            document.body.innerHTML = original;
            location.reload();

        }
    </script>
@endpush
