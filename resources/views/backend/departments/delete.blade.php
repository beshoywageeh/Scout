<div class="modal fade" id="delete_department{{$department->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="exampleModalLabel">
                    <div class="mb-10">
                        <h4>حذف قطاع</h4>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form action="{{route('department.delete')}}" id="department_delete{{$department->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$department->id}}">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <h5 class="text-danger">هل من انت متاكد من حذف ؟</h5>
                            <input type="text" class='form-control' value="{{$department->name}}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button"  class="btn btn-danger" onclick="event.preventDefault();document.getElementById('department_delete{{$department->id}}').submit();">حفظ</button>

                    <button type="button" class="btn btn-gray" data-dismiss="modal">اغلاق</button>

                </div>
            </div>
        </div>
    </div>
</div>
