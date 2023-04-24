<div class="modal fade" id="delete_user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="exampleModalLabel">
                    <div class="mb-10">
                        <h4>حذف نهائي</h4>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form action="{{route('user.force_delete')}}" id="delete_user" method="post">
                    @csrf
                    <input type="hidden" name="id" id="user_code"  value="">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <h5 class="text-danger">هل انت متاكد من الحذف ؟</h5>
                            <input type="text" class='form-control' id="user_name" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button"  class="btn btn-danger" onclick="event.preventDefault();document.getElementById('delete_user').submit();">حذف</button>
                    <button type="button" class="btn btn-gray" data-dismiss="modal">اغلاق</button>

                </div>
            </div>
        </div>
    </div>
</div>
