@php
    $dep = $department->name;
    $heading = 'اضافة حضور وغياب لقطاع '.$dep;
@endphp
@extends('layouts.app')
@section('title')
    {{$heading}}
@endsection
@push('css')
    <style>
        #user-table > thead > tr > th {
            text-align: center !important;
        }

    </style>
@endpush

@section('content-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 font_cairo">{{$heading}}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}"
                                                   class="default-color">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item active">{{$heading}}</li>
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
                    <button class="button small" type="submit"
                            onclick="document.getElementById('submit_attendance').submit()"><i
                            class="ti-plus mr-2"></i><strong>حفظ</strong>
                    </button>
                    <button class="button small ml-3" data-toggle="modal" data-target="#upload"><i
                            class="ti-upload mr-2"></i><strong>رفع</strong>
                    </button>
                    <form method="POST" action="{{route('attendance.store')}}" id="submit_attendance">
                        @csrf
<div class="col-lg">
    <div class="form-group">
        <div class="input-group date" id="datepicker-action" data-date-format='yyyy-mm-dd'>
            <input class="form-control form-control-sm date-picker-default" type="text" placeholder="تاريخ"
            name="att_date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
</div>
                        <div class="table-responsive">

                            <table id="user_table" name="att_list" class="table table-striped table-bordered p-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>كود</th>
                                    <th>الاسم</th>
                                    <th>العمليات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user )
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$user->code}}</td>
                                        <td>{{ $user->first_name.' '.$user->second_name.' '.$user->third_name }}</td>
                                        <td>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="attendance[{{$user->code}}]"
                                                               id="gridRadios1"
                                                               value="attendance">
                                                        <label class="form-check-label text-primary"
                                                               style="font-weight: bold" for="gridRadios1">
                                                            حضور
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="attendance[{{$user->code}}]"
                                                               id="gridRadios1"
                                                               value="absent" checked>
                                                        <label class="form-check-label text-danger"
                                                               style="font-weight: bold" for="gridRadios1">
                                                            غياب
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="attendance[{{$user->code}}]"
                                                               id="gridRadios1"
                                                               value="eatezar">
                                                        <label class="form-check-label text-warning"
                                                               style="font-weight: bold" for="gridRadios1">
                                                            اعتذار
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="user_id[]" value="{{ $user->code }}">
                                            <input type="hidden" name="department_id"
                                                   value="{{ $user->department_id }}">
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>





@endsection
@push('script')
    <script>

/*
        $(document).ready(function () {
            $('#user_table').DataTable(
                {
                    language: {
                        "loadingRecords": "جارٍ التحميل...",
                        "lengthMenu": "أظهر _MENU_ مدخلات",
                        "zeroRecords": "لم يعثر على أية سجلات",
                        "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                        "search": "ابحث:",
                        "paginate": {
                            "first": "الأول",
                            "previous": "السابق",
                            "next": "التالي",
                            "last": "الأخير"
                        },
                        "aria": {
                            "sortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                            "sortDescending": ": تفعيل لترتيب العمود تنازلياً"
                        },
                        "select": {
                            "rows": {
                                "_": "%d قيمة محددة",
                                "1": "1 قيمة محددة"
                            },
                            "cells": {
                                "1": "1 خلية محددة",
                                "_": "%d خلايا محددة"
                            },
                            "columns": {
                                "1": "1 عمود محدد",
                                "_": "%d أعمدة محددة"
                            }
                        },
                        "buttons": {
                            "print": "طباعة",
                            "copyKeys": "زر <i>ctrl<\/i> أو <i>⌘<\/i> + <i>C<\/i> من الجدول<br>ليتم نسخها إلى الحافظة<br><br>للإلغاء اضغط على الرسالة أو اضغط على زر الخروج.",
                            "pageLength": {
                                "-1": "اظهار الكل",
                                "_": "إظهار %d أسطر",
                                "1": "اظهار سطر واحد"
                            },
                            "collection": "مجموعة",
                            "copy": "نسخ",
                            "copyTitle": "نسخ إلى الحافظة",
                            "csv": "CSV",
                            "excel": "Excel",
                            "pdf": "PDF",
                            "colvis": "إظهار الأعمدة",
                            "colvisRestore": "إستعادة العرض",
                            "copySuccess": {
                                "1": "تم نسخ سطر واحد الى الحافظة",
                                "_": "تم نسخ %ds أسطر الى الحافظة"
                            },
                            "createState": "تكوين حالة",
                            "removeAllStates": "ازالة جميع الحالات",
                            "removeState": "ازالة حالة",
                            "renameState": "تغيير اسم حالة",
                            "savedStates": "الحالات المحفوظة",
                            "stateRestore": "استرجاع حالة",
                            "updateState": "تحديث حالة"
                        },
                        "searchBuilder": {
                            "add": "اضافة شرط",
                            "clearAll": "ازالة الكل",
                            "condition": "الشرط",
                            "data": "المعلومة",
                            "logicAnd": "و",
                            "logicOr": "أو",
                            "value": "القيمة",
                            "conditions": {
                                "date": {
                                    "after": "بعد",
                                    "before": "قبل",
                                    "between": "بين",
                                    "empty": "فارغ",
                                    "equals": "تساوي",
                                    "notBetween": "ليست بين",
                                    "notEmpty": "ليست فارغة",
                                    "not": "ليست "
                                },
                                "number": {
                                    "between": "بين",
                                    "empty": "فارغة",
                                    "equals": "تساوي",
                                    "gt": "أكبر من",
                                    "lt": "أقل من",
                                    "not": "ليست",
                                    "notBetween": "ليست بين",
                                    "notEmpty": "ليست فارغة",
                                    "gte": "أكبر أو تساوي",
                                    "lte": "أقل أو تساوي"
                                },
                                "string": {
                                    "not": "ليست",
                                    "notEmpty": "ليست فارغة",
                                    "startsWith": " تبدأ بـ ",
                                    "contains": "تحتوي",
                                    "empty": "فارغة",
                                    "endsWith": "تنتهي ب",
                                    "equals": "تساوي",
                                    "notContains": "لا تحتوي",
                                    "notStartsWith": "لا تبدأ بـ",
                                    "notEndsWith": "لا تنتهي بـ"
                                },
                                "array": {
                                    "equals": "تساوي",
                                    "empty": "فارغة",
                                    "contains": "تحتوي",
                                    "not": "ليست",
                                    "notEmpty": "ليست فارغة",
                                    "without": "بدون"
                                }
                            },
                            "button": {
                                "0": "فلاتر البحث",
                                "_": "فلاتر البحث (%d)"
                            },
                            "deleteTitle": "حذف فلاتر",
                            "leftTitle": "محاذاة يسار",
                            "rightTitle": "محاذاة يمين",
                            "title": {
                                "0": "البحث المتقدم",
                                "_": "البحث المتقدم (فعال)"
                            }
                        },
                        "searchPanes": {
                            "clearMessage": "ازالة الكل",
                            "collapse": {
                                "0": "بحث",
                                "_": "بحث (%d)"
                            },
                            "count": "عدد",
                            "countFiltered": "عدد المفلتر",
                            "loadMessage": "جارِ التحميل ...",
                            "title": "الفلاتر النشطة",
                            "showMessage": "إظهار الجميع",
                            "collapseMessage": "إخفاء الجميع",
                            "emptyPanes": "لا يوجد مربع بحث"
                        },
                        "infoThousands": ",",
                        "datetime": {
                            "previous": "السابق",
                            "next": "التالي",
                            "hours": "الساعة",
                            "minutes": "الدقيقة",
                            "seconds": "الثانية",
                            "unknown": "-",
                            "amPm": [
                                "صباحا",
                                "مساءا"
                            ],
                            "weekdays": [
                                "الأحد",
                                "الإثنين",
                                "الثلاثاء",
                                "الأربعاء",
                                "الخميس",
                                "الجمعة",
                                "السبت"
                            ],
                            "months": [
                                "يناير",
                                "فبراير",
                                "مارس",
                                "أبريل",
                                "مايو",
                                "يونيو",
                                "يوليو",
                                "أغسطس",
                                "سبتمبر",
                                "أكتوبر",
                                "نوفمبر",
                                "ديسمبر"
                            ]
                        },
                        "editor": {
                            "close": "إغلاق",
                            "create": {
                                "button": "إضافة",
                                "title": "إضافة جديدة",
                                "submit": "إرسال"
                            },
                            "edit": {
                                "button": "تعديل",
                                "title": "تعديل السجل",
                                "submit": "تحديث"
                            },
                            "remove": {
                                "button": "حذف",
                                "title": "حذف",
                                "submit": "حذف",
                                "confirm": {
                                    "_": "هل أنت متأكد من رغبتك في حذف السجلات %d المحددة؟",
                                    "1": "هل أنت متأكد من رغبتك في حذف السجل؟"
                                }
                            },
                            "error": {
                                "system": "حدث خطأ ما"
                            },
                            "multi": {
                                "title": "قيم متعدية",
                                "restore": "تراجع",
                                "info": "القيم المختارة تحتوى على عدة قيم لهذا المدخل. لتعديل وتحديد جميع القيم لهذا المدخل، اضغط او انتقل هنا، عدا ذلك سيبقى نفس القيم",
                                "noMulti": "هذا المدخل مفرد وليس ضمن مجموعة"
                            }
                        },
                        "processing": "جارٍ المعالجة...",
                        "emptyTable": "لا يوجد بيانات متاحة في الجدول",
                        "infoEmpty": "يعرض 0 إلى 0 من أصل 0 مُدخل",
                        "thousands": ".",
                        "stateRestore": {
                            "creationModal": {
                                "columns": {
                                    "search": "إمكانية البحث للعمود",
                                    "visible": "إظهار العمود"
                                },
                                "toggleLabel": "تتضمن",
                                "button": "تكوين الحالة",
                                "name": "اسم الحالة",
                                "order": "فرز",
                                "paging": "تصحيف",
                                "scroller": "مكان السحب",
                                "search": "بحث",
                                "searchBuilder": "مكون البحث",
                                "select": "تحديد",
                                "title": "تكوين حالة جديدة"
                            },
                            "duplicateError": "حالة مكررة بنفس الاسم",
                            "emptyError": "لا يسمح بأن يكون اسم الحالة فارغة.",
                            "emptyStates": "لا توجد حالة محفوظة",
                            "removeConfirm": "هل أنت متأكد من حذف الحالة %s؟",
                            "removeError": "لم استطع ازالة الحالة.",
                            "removeJoiner": "و",
                            "removeSubmit": "حذف",
                            "removeTitle": "حذف حالة",
                            "renameButton": "تغيير اسم حالة",
                            "renameLabel": "الاسم الجديد للحالة %s:",
                            "renameTitle": "تغيير اسم الحالة"
                        },
                        "autoFill": {
                            "cancel": "إلغاء الامر",
                            "fill": "املأ كل الخلايا بـ <i>%d<\/i>",
                            "fillHorizontal": "تعبئة الخلايا أفقيًا",
                            "fillVertical": "تعبئة الخلايا عموديا",
                            "info": "تعبئة تلقائية"
                        },
                        "decimal": ",",
                        "infoFiltered": "(مرشحة من مجموع _MAX_ مُدخل)",
                        "searchPlaceholder": "مثال بحث"
                    },
                });
        });
*/
    </script>

@endpush
