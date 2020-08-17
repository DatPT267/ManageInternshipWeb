@extends('admin.layout.index')
@section('content')
    <h1>Danh sách thành viên nhóm <strong>{{$nameGroup}}</strong></h1>
    @if (session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
            {{-- {{session('success')}} --}}
        </div>
    @endif
    <table class="table table-striped table-bordered table-hover" id="example">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Ảnh đại diện</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Đợt thực tập</th>
                <th>Chức vụ</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
            <tr class="odd gradeX" align="center">
                <td>{{$member->id}}</td>
                <td>
                    <img src="/image/user/{{$member->user->image}}" width="100px" height="100px">
                </td>
                <td>{{$member->user->name}}</td>
                <td>{{$member->user->email}}</td>
                <td>{{$member->user->address}}</td>
                <td>{{$member->user->phone}}</td>
                <td>{{$member->user->internshipClass->name}}</td>
                <td>
                    @if ($member->position == 0)
                        Thành viên
                    @endif
                    @if ($member->position == 1)
                        Nhóm trưởng
                    @endif
                    @if ($member->position == 2)
                        GVHD
                    @endif
                </td>
                <td class="center">
                    <a href="/admin/group/{{$member->group_id}}/delMember/{{$member->user_id}}"><i class="fas fa-trash-alt" ></i> Delete</a>
                    {{-- <button" class="btn btn-danger btn-delete" data-url="{{route("member.delete", 2, $member->user_id)}}" data-id="{{$member->user_id}}"> Delete</button> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
@section('script')'
<script>
    $(document).ready(function () {
        $('.btn-delete').click(function (e) {
            var id = $(this).data('id');
            var url = $(this).attr('data-url');
            $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function (res) {
                        if (res == 'ok') {
                            //xóa thành công -> ẩn dòng đó đi
                            alert('ok')
                        } else {
                            alert('Dữ liệu không tồn tại!');
                        }
                    },
                    error: function () {
                        alert('Lỗi xảy ra');
                    }
            });
        });
    });
</script>
@endsection
