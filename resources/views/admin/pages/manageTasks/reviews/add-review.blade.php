<div class="modal fade modal-create-review" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Thêm review</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('post-review', $id_task)}}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" cols="105" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Đăng</button>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-facebook">Close</button>
            </div>
        </div>
    </div>
</div>
