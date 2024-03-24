@extends('layouts.app')
@section('title')
    الميزانية
@endsection
@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">الميزانية</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('payment.index') }}" class="default-color">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">الميزانية</li>
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
                <form action="{{ route('payment.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">البند</label>
                            <input class="form-control form-control-sm" type="search" name="note"
                                placeholder="البند">
                        </div>

                        <div class="col-lg-2">
                            <label for="">إختر البند</label>
                            <select class="custom-select" name="type">
                                <option value="" selected disabled>اختر النوع</option>
                                <option value="1">وارد</option>
                                <option value="2">منصرف</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="">التاريخ</label>
                            <input class="form-control form-control-sm" type="date" name="date"
                                placeholder="التاريخ">
                        </div>
                        <div class="col-lg-2">
                            <label for="">القيمة</label>
                            <input class="form-control form-control-sm" type="text" name="amount"
                                placeholder="القيمة">
                        </div>
                        <div class="col-lg-2"><button wire.click="savepayment" class="btn btn-block btn-primary">حفظ</button>
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered p-0 text-center">
                        <thead>
                            <tr>
                                <th>إجمالي الدخل</th>
                                <th>إجمالي المنصرف</th>
                                <th>المجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{number_format($data['in'], '2')}} ج.م</td>
                                <td>{{number_format($data['out'], '2')}} ج.م</td>
                                <td>{{number_format($data['payments_total'], '2')}} ج.م</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 mb-30">

        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered p-0 text-center user_table">
                        <thead>
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2">البند</th>
                                <th rowspan="2">التاريخ</th>
                                <th colspan="2">القيمة</th>
                                <th rowspan="2">العمليات</th>
                            </tr>
                            <tr>
                                <td>داخل</td>
                                <td>منصرف</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['payments'] as $payment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $payment->note }}</td>
                                    <td>{{ $payment->at }}</td>
                                    <td>{{ $payment->in }}</td>
                                    <td>{{ $payment->out }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@push('script')
    <script src="{{ asset('js/inital_data_table.js') }}"></script>
@endpush
