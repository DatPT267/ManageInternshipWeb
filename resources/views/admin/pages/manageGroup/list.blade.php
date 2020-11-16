@extends('admin.layout.index')
@section('content')
    <h1>Danh sách nhóm</h1>
    <a href="{{ route('manageGroup.create') }}" class="btn btn-primary">Thêm nhóm</a>
    <table class="table table-striped table-bordered table-hover" id="table-group">
        <thead>
            <tr >
                <th>STT</th>
                <th>Tên Nhóm</th>
                <th>Đề Tài</th>
                <th>Tên đợt thực tập</th>
                <th>Trạng thái</th>
                <th>Ghi chú</th>
                <th>Danh sách thành viên</th>
                <th>Đánh giá</th>
                <th>Hoạt động</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; ?>
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
                <td>
                    @if($group->status==1)
                        Hoạt động
                    @else
                        Không hoạt động
                    @endif
                </td>
                <td>{{$group->note}}</td>
                <td>
                    <a href="{{ route('group.listMember', $group->id) }}" class="btn btn-success">Xem</a>
                </td>
                <td>
                    <a href="{{route('group.list-review', $group->id)}}" class="btn btn-secondary">Xem</a>
                </td>
                <td class="center">
                    <a href="{{route('manageGroup.edit', $group->id)}}" class="btn btn-info">Cập nhật</a>
                    <a href="{{ route('listtask', $group->id) }}" class="btn btn-warning">Task</a>
                    <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target=".modal-delete-group" data-url="{{route('manageGroup.destroy', $group->id)}}">Xóa</button>
                </td>
            </tr>
            @endforeach
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form id="form-delete-group" action="" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Xóa" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('#table-group').dataTable({
                info: false,
                bLengthChange: false,
                pageLength: 5,
                columns: [
                    {'orderable': true},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                ]
            });

            $('.btn-delete').click(function (){
                var url = $(this).attr('data-url');
                $('form#form-delete-group').attr('action', url);
            })
        })
    </script>
@endsection
