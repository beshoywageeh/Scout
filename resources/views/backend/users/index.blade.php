@extends('layouts.app')
@section('title')
    الافراد
@endsection
@push('css')
    <style>
        #user-table>thead>tr>th {
            text-align: center !important;
        }

        .badge-black {
            color: #fff;
            background-color: black;
        }
    </style>
@endpush
@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">الافراد</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="default-color">الرئيسية

                        </a>
                    </li>
                    <li class="breadcrumb-item active">الافراد</li>
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
                @include('backend.users.upload')
                <div class="card-body">
                    @can('اضافة فرد')
                        <a class="button small" href="{{ route('user.create') }}"><i
                                class="ti-plus mr-2"></i><strong>اضف</strong>
                        </a>
                    @endcan
                    @can('استيراد اكسيل')
                        <button class="button small ml-3" data-toggle="modal" data-target="#upload"><i
                                class="ti-upload mr-2"></i><strong>رفع</strong>
                        </button>
                    @endcan
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered p-0 user_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الفريق</th>
                                    <th>الكود</th>
                                    <th width="20%">الاسم</th>
                                    <th>العنوان</th>
                                    <th>رقم التليفون</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->department->name }}</td>
                                        <td>{{ $user->code }}</td>
                                        <td>{{ $user->full_name() }}
                                            <br>
                                            {!! $user->archive_check() !!}
                                            {!! $user->black_list_check() !!}
                                        </td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->phone_number }}</td>

                                        <td>
                                            <div class="btn-group ">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">العمليات
                                                </button>
                                                <button type="button"
                                                    class="btn btn-success btn-sm dropdown-toggle dropdown-toggle-split"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('user.edit', ['id' => $user->id]) }}"
                                                        class="dropdown-item"><i
                                                            class="ti-pencil-alt mr-2 text-warning"></i><strong>تعديل</strong>
                                                    </a>
                                                    <a href="{{ route('user.profile', ['id' => $user->code]) }}"
                                                        class="dropdown-item"><i
                                                            class="ti-eye mr-2 text-info"></i><strong>تفاصيل</strong>
                                                    </a>
                                                    @if ($user->deleted_at == null)
                                                        <button class="dropdown-item archive" data-toggle="modal"
                                                            data-target="#archive_user"
                                                            data-user_code="{{ $user->code }}"
                                                            data-user_name="{{ $user->first_name . ' ' . $user->second_name . ' ' . $user->third_name }}"><i
                                                                class="ti-archive mr-2 text-danger"></i><strong>ارشيف</strong>
                                                        </button>

                                                        <button class="dropdown-item archive" data-toggle="modal"
                                                            data-target="#personal_attend_user"
                                                            data-user_code="{{ $user->code }}"
                                                            data-user_department="{{ $user->department_id }}"
                                                            data-user_name="{{ $user->first_name . ' ' . $user->second_name . ' ' . $user->third_name }}"><i
                                                                class="ti-calendar mr-2 text-primary"></i><strong>تسجيل
                                                                حضور</strong>
                                                        </button>
                                                    @else
                                                        <button href='{{ route('user.restore') }}'
                                                            class='dropdown-item restore'data-toggle="modal"
                                                            data-target="#restore_user"
                                                            data-user_code="{{ $user->code }}"
                                                            data-user_name="{{ $user->first_name . ' ' . $user->second_name . ' ' . $user->third_name }}">
                                                            <i class='text-danger ti-reload mr-2'></i>
                                                            <strong>ارجاع</strong></button>
                                                    @endif
                                                    @if ($user->blank_list == null)
                                                        <button data-toggle="modal" data-target="#black_list_user"
                                                            data-user_code="{{ $user->code }}"
                                                            data-user_name="{{ $user->first_name . ' ' . $user->second_name . ' ' . $user->third_name }}"
                                                            class="dropdown-item"><i
                                                                class="ti-list mr-2 text-secondary"></i><strong>بلاك
                                                                ليست</strong>
                                                        </button>
                                                    @endif
                                                    <button class="dropdown-item" data-toggle="modal"
                                                        data-target="#delete_user" data-user_code="{{ $user->code }}"
                                                        data-user_name="{{ $user->first_name . ' ' . $user->second_name . ' ' . $user->third_name }}"><i
                                                            class="ti-trash mr-2 text-danger"></i><strong>حذف</strong>
                                                    </button>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @include('backend.users.delete')
                                @include('backend.users.archive')
                                @include('backend.users.restore')
                                @include('backend.users.black_list')
                                @include('backend.users.personal_attendance')
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
    <script>
        $('#archive_user').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_code = button.data('user_code')
            var user_name = button.data('user_name')
            var modal = $(this)
            modal.find('.modal-body #user_code').val(user_code);
            modal.find('.modal-body #user_name').val(user_name);
        })
    </script>
    <script>
        $('#delete_user').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_code = button.data('user_code')
            var user_name = button.data('user_name')
            var modal = $(this)
            modal.find('.modal-body #user_code').val(user_code);
            modal.find('.modal-body #user_name').val(user_name);
        })
    </script>
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
    <script>
        $('#black_list_user').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_code = button.data('user_code')
            var user_name = button.data('user_name')
            var modal = $(this)
            modal.find('.modal-body #user_code').val(user_code);
            modal.find('.modal-body #user_name').val(user_name);
        })
    </script>
    <script>
        $('#personal_attend_user').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_code = button.data('user_code')
            var user_name = button.data('user_name')
            var user_department = button.data('user_department')
            var modal = $(this)
            modal.find('.modal-body #user_code').val(user_code);
            modal.find('.modal-body #user_name').val(user_name);
            modal.find('.modal-body #user_department').val(user_department);
        })
    </script>
@endpush
