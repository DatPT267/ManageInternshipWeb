<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm review</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('post.group.list-review', $id_group)}}" method="POST">
                    @csrf
                    <textarea name="content" id="" cols="105" rows="5" placeholder="Viết reivew"></textarea>
                    <button type="submit" class="btn btn-success">Đăng</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
            </div>
        </div>
    </div>
</div>
