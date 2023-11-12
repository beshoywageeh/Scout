@extends('layouts.app')
@section('title')
    تعدبل فرد
@endsection

@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">تعديل فرد</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.edit') }}" class="default-color">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">تعديل فرد</li>
                </ol>
            </div>
        </div>
    </div>
    @include('backend.msg')
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="mb-10">
                    <h4 class="text-white font-bold text-center">تعديل</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('user.update') }}" method="post" id="edit_person" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $data['user']->id }}" name="id">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-10">
                                    <div class="col-lg-12">
                                        <input type="file" name="logo" accept="image/*" id="logo"
                                            onchange="showPreview(event)" hidden>
                                        @if (is_null($data['user']->image))
                                            <img src="{{ asset('images/team/01.jpg') }}" style="margin-right: 50%"
                                                class="img-fluid w-25 avatar rounded-circle user-avatar"
                                                onclick="  $('#logo').trigger('click');" id="preview">
                                        @else
                                            <img src="{{ asset('attachments/users') . '/' . $data['user']->first_name . ' ' . $data['user']->second_name . '/' . $data['user']->image->filename }}"
                                                style="margin-right: 50%"
                                                class="img-fluid w-25 avatar rounded-circle user-avatar"
                                                onclick="  $('#logo').trigger('click');" id="preview">
                                        @endif
                                    </div>

                                </div>
                                <div class="row mb-10">
                                    <div class="col-lg-6"><input
                                            class="form-control @error('first_name') is-invalid @enderror form-control-sm"
                                            type="text" placeholder="الاسم الاول" name="first_name" aria-required=""
                                            value="{{ $data['user']->first_name }}">
                                        @error('first_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <input
                                            class="form-control @error('second_name') is-invalid @enderror form-control-sm"
                                            type="text" placeholder="الاسم الثاني" name="second_name" required
                                            value="{{ $data['user']->second_name }}">
                                        @error('second_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-10">
                                    <div class="col-lg-6"><input class="form-control form-control-sm" type="text"
                                            placeholder="الاسم الثالث" name="third_name"
                                            value="{{ $data['user']->third_name }}"></div>
                                    <div class="col-lg-6"><input class="form-control form-control-sm" type="text"
                                            placeholder="الاسم الرابع" name="foruth_name"
                                            value="{{ $data['user']->fourth_name }}"></div>
                                </div>
                                <div class="row mb-10">
                                    <div class="col-lg-6">
                                        <label for="">تاريخ الميلاد</label>
                                        <input class="form-control form-control-sm date-picker-default" type="date"
                                            name="birth_date" value="{{ $data['user']->birth_date }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">رقم التلبفون </label>
                                        <input class="form-control form-control-sm"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                            value="{{ $data['user']->phone_number }}" type="text" name="phone_number"
                                            placeholder="رقم التليفون ">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <div class="row mb-10">
                                    <div class="col-lg-12">
                                        <label for="">العنوان</label>
                                        <textarea class="form-control form-control-sm" name="address">{{ $data['user']->address }}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="row mb-10">
                                    <div class="col-lg-6">
                                        <label>الفريق</label>
                                        <select class="custom-select" name="department_id" id="department">
                                            @foreach ($data['department'] as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ $department->id == $data['user']->department_id ? 'selected' : '' }}>
                                                    {{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">تليفون البيت</label>
                                        <input class="form-control form-control-sm" type="text" name="home_phone"
                                            placeholder="تليفون البيت" value="{{ $data['user']->home_number }}">
                                    </div>
                                </div>
                                <div class="row mb-10">

                                    <div class="col-lg-6">
                                        <label for="">اب الاعترف</label>
                                        <input class="form-control form-control-sm" type="text" name="chruch_father"
                                            {{ $data['user']->church_father }}>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="">تاريخ الاشتراك</label>
                                                    <input class="form-control form-control-sm date-picker-default" type="date" name="join_date"
                                                        value="{{ $data['user']->join_date }}">
                                                </div>
                                            </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="">شارات</label>
                                        <select name="badges[]" id="badges" multiple class="custom-select">

                                        </select>
                                    </div>
                                </div>
                                @can('صلاحيه الدخول')
                                    <div class="row mb-10 mt-10">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="active"
                                                    id="gridRadios1" value="active"
                                                    {{ $data['user']->login_allow == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios1">
                                                    تفعيل الدخول
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <label for="">كلمه المرور</label>
                                            <input class="form-control form-control-sm" type="password" name="password">
                                        </div>
                                        <div class="col">
                                            <label>صلاحيه</label>
                                            <select class="custom-select" name="role" id="">
                                                @foreach ($data['roles'] as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">حفظ
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function showPreview(event) {
            if (event.target.files.length > 0) {
                let src = URL.createObjectURL(event.target.files[0]),
                    preview = document.getElementById("preview");
                preview.src = src;
            }
        }
    </script>
    <script>
        let
            badges = document.querySelector('#badges');
        $(document).on('change', '#department', function(e) {
            let department = $(this).val();
            $.ajax({
                method: "GET",
                url: "{{ route('user.getbadges_ajax') }}/" + department,
                cache: false,
                datatype: 'json',
                success: function(data) {
                    $('select[name="badges[]"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="badges[]"]').append('<option value="' +
                            key + '">' + value + '</option>');
                    });

                },
            });
        });
    </script>
@endpush
