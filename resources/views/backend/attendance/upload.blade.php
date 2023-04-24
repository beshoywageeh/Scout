<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="upload">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <div class="modal-title">
                    <div class="mb-10">
                        <h4 class="text-white font-bold text-center">رفع البيانات</h4>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('attendance.upload')}}" method="post" id="upload" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="file" name="data">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">حفظ
                    </button>

                </form>
            </div>
            <div class="modal-footer bg-info">
                <div class="btn-group" role="group">

                    <button type="button" class="btn btn-gray" data-dismiss="modal">اغلاق</button>

                </div>
            </div>
        </div>
    </div>
</div>
