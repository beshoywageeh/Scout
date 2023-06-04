<div class="modal fade" id="personal_attend_user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="exampleModalLabel">
                    <div class="mb-10">
                        <h4>حضور</h4>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form action="{{route('attendance.personal_attendance')}}" id="personal_attendance_user" method="post">
                    @csrf
                    <input type="hidden" name="id" id="user_code"  value="">
                    <input type="hidden" name="department_id" id="user_department"  value="">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <h5 class="text-danger">إضافة تمام</h5>
                            <input type="text" class='form-control' id="user_name" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-5">
                            <h5 class="text-primary">تاريخ</h5>
                            <input type="date" class='form-control' name="attendace_date">
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                               name="attendance"
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
                                               name="attendance"
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
                                               name="attendance"
                                               id="gridRadios1"
                                               value="eatezar">
                                        <label class="form-check-label text-warning"
                                               style="font-weight: bold" for="gridRadios1">
                                            اعتذار
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button"  class="btn btn-danger" onclick="event.preventDefault();document.getElementById('personal_attendance_user').submit();">حفظ</button>
                    <button type="button" class="btn btn-gray" data-dismiss="modal">اغلاق</button>

                </div>
            </div>
        </div>
    </div>
</div>
