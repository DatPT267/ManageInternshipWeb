<div class="modal fade modal-create" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm phản hồi</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('create-feedback-review', $id_review)}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" cols="105" rows="5" placeholder="Viết feedback"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Đăng</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
            </div>
        </div>
    </div>
</div>
