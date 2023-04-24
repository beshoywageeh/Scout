<div class="modal fade" id="create_department" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="exampleModalLabel">
                    <div class="mb-30">
                        <h4>اضف قطاع</h4>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form action="{{route('department.store')}}" id="department_store" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <label for="department_name">اسم القطاع</label>
                            <input type="text" class='form-control' name="name" placeholder="اسم القطاع" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <label for="department_name">اختار الشعار</label>
                            <input type="file" name="logo" accept="image/*" id="logo" onchange="showPreview(event)">
                        </div>
                        <div class="col-lg-4">
                            <img src=""
                                 class="img img-responsive img-thumbnail" id="preview">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button"  class="btn btn-primary " onclick="event.preventDefault();document.getElementById('department_store').submit();">حفظ</button>

                    <button type="button" class="btn btn-gray" data-dismiss="modal">اغلاق</button>

                </div>
            </div>
        </div>
    </div>
</div>
