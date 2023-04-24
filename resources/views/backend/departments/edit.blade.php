<div class="modal fade" id="edit_department{{$department->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="exampleModalLabel">
                    <div class="mb-30">
                        <h4>تعديل</h4>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form action="{{route('department.edit')}}" id="department_edit{{$department->id}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$department->id}}" name="id">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <label for="department_name">اسم القطاع</label>
                            <input type="text" class='form-control' name="name" placeholder="اسم القطاع"
                                   value="{{$department->name}}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <label for="department_name">اختار الشعار</label>
                            <input type="file" name="logo" accept="image/*" id="logo" onchange="showPreview(event)">
                        </div>

                        <div class="col-lg-4">

                            <img class='img-fluid w-50  rounded-circle'
                                 src="{{is_null($department->image)?asset('images/login-banner.jpg'):asset('attachments/departments/' . $department->image->filename)}}
                                     " id="preview">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary "
                            onclick="event.preventDefault();document.getElementById('department_edit{{$department->id}}').submit();">
                        حفظ
                    </button>

                    <button type="button" class="btn btn-gray" data-dismiss="modal">اغلاق</button>

                </div>
            </div>
        </div>
    </div>
</div>
