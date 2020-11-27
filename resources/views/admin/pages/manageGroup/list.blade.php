@extends('admin.layout.index')
@section('content')
    <h1>Danh sách nhóm</h1>
    <a href="{{ route('manageGroup.create') }}" class="btn btn-primary">Thêm nhóm</a>
    <form action="{{ route('manageGroup.index')  }}" method="get" class="form-inline mt-3">
        <div class="input-group mb-3  mr-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Tên nhóm</span>
            </div>
            <input type="text" class="form-control" name="nameGroupSearch" value="{{ Request::get('nameGroupSearch') }}">
        </div>
        <div class="input-group mb-3 mr-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Tên đề tài</span>
            </div>
            <input type="text" class="form-control" name="nameTopicSearch" value="{{ Request::get('nameTopicSearch') }}">
        </div>
        <div class="input-group mb-3 mr-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Tên đợt</span>
            </div>
            <input type="text" class="form-control" name="nameInternshipClassSearch" value="{{ Request::get('nameInternshipClassSearch') }}">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
            <a href="{{ route('manageGroup.index')  }}" class="btn btn-secondary"><i class="fas fa-sync-alt"></i></a>
        </div>
    </form>
    <table class="table table-striped table-bordered table-hover" id="table-group">
        <thead>
            <tr >
                <th>STT</th>
                <th>Tên Nhóm</th>
                <th>Đề Tài</th>
                <th>Tên đợt thực tập</th>
                <th>Ghi chú</th>
                <th>Trạng thái</th>
                <th>Hoạt động</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; ?>
            @if (count($groups) > 0)
                @foreach ($groups as $group)
                <tr class="odd gradeX" >
                    <td>
                        {{++$i}}
                    </td>
                    <td>
                        {{$group->name}}
                    </td>
                    <td>
                        {{$group->topic}}
                    </td>
                    <td>
                        {{$group->internshipClass->name}}
                    </td>
                    <td>{{$group->note}}</td>
                    <td>
                        <a class="btn btn-default btn-flat activateCourse-22 ">
                            @if ($group->status == 0)
                                <i class="fas fa-toggle-off active-status-student" style="font-size: 30px" data-status="{{ $group->status }}" data-id="{{ $group->id }}"></i>
                            @else
                                <i class="fas fa-toggle-on active-status-student" style="color: green; font-size: 30px" data-status="{{ $group->status }}" data-id="{{ $group->id }}"></i>
                            @endif
                        </a>
                    </td>
                    <td class="center" >
                        <a href="{{ route('listtask', $group->id) }}" class="btn btn-warning">Task</a>
                        <a href="{{route('manageGroup.edit', $group->id)}}" class="btn btn-info">Cập nhật</a>
                        <a href="{{ route('group.listMember', $group->id) }}" class="btn btn-success">Xem danh sách thành viên</a>
                        <a href="{{route('group.list-review', $group->id)}}" class="btn btn-secondary">Xem đánh giá</a>
                        <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target=".modal-delete-group" data-url="{{route('manageGroup.destroy', $group->id)}}">Xóa</button>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" align="center"><strong>Không có dữ liệu</strong></td>
                </tr>
            @endif
        </tbody>
    </table>
    <!-- Large modal -->

<div class="modal fade modal-delete-group" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Xác nhận xóa?</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1>Bạn có muốn xóa?</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                <form id="form-delete-group" action="" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Có" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade show-modal-change-status-group" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                Xác nhận thay đổi?
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3><strong>Bạn có muốn thay đổi trạng thái?</strong></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Không</button>
                <button type="button" class="btn btn-danger btn-submit-status">Có</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){

            $('.btn-delete').click(function (){
                var url = $(this).attr('data-url');
                $('form#form-delete-group').attr('action', url);
            })

            $.ajaxSetup({
                headers:
                { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            function changeStatus(id, status){
                $.ajax({
                    type: "PUT",
                    url: "{{ route('changeStatusGroup') }}",
                    data: {status: status, id: id},
                    dataType: "json",
                    success: function (res) {

                    }
                });
            }
            $('.active-status-student').click(function () {
                var status = $(this).attr('data-status');
                var id = $(this).attr('data-id');
                var parentButton = this;
                $('.show-modal-change-status-group').modal('show');

                if(status == 1){
                    $('.btn-submit-status').click(function (){
                        changeStatus(id, status);
                        $(parentButton).attr('class', 'fas fa-toggle-off');
                        $(parentButton).attr('data-status', 0);
                        $(parentButton).css('color', "");
                        $('.show-modal-change-status-group').modal('hide');
                    })
                } else{
                    $('.btn-submit-status').click(function (){
                        changeStatus(id, status);
                        $(parentButton).attr('class', 'fas fa-toggle-on');
                        $(parentButton).attr('data-status', 1);
                        $(parentButton).css('color', "green");
                        $('.show-modal-change-status-group').modal('hide');
                    })
                }
            });
        })
    </script>
@endsection
