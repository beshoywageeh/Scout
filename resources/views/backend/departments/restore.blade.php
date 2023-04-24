<div class="modal fade" id="restore_user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="exampleModalLabel">
                    <div class="mb-10">
                        <h4>ارجاع</h4>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form action="{{route('user.restore')}}" id="user_restore" method="post">
                    @csrf
                    <input type="hidden" name="id" id="user_code" value="">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <h5 class="text-danger">هل انت متاكد من الارجاع ؟</h5>
                            <input type="text" class='form-control' id="user_name" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button"  class="btn btn-danger" onclick="event.preventDefault();document.getElementById('user_restore').submit();">ارجاع</button>
                    <button type="button" class="btn btn-gray" data-dismiss="modal">اغلاق</button>

                </div>
            </div>
        </div>
    </div>
</div>
