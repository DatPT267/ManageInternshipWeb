@extends('admin.layout.index')
@section('content')
<div class="container-fluid">
    <h1>Danh sách thành viên nhóm <strong>{{$group->name}}</strong></h1>
    <a href="{{ route('group.addMember', $group->id) }}" class="btn btn-primary mb-3">Thêm sinh viên vào nhóm</a>
    <table class="table table-striped table-bordered table-hover" id="list-member">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Ảnh đại diện</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Chức vụ</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            @foreach ($members as $member)
            <tr class="odd gradeX" align="center">
                <td>{{$index++}}</td>
                <td>
                    @if ($member->user->image != null)
                        <img src="{{asset('image/user')}}/{{$member->user->image}}" width="100px" height="100px">
                    @else
                        <img src="{{asset('image/user/avatar.jpg')}}" width="100px" height="100px">
                    @endif
                </td>
                <td>{{$member->user->name}}</td>
                <td>{{$member->user->email}}</td>
                <td>{{$member->user->address}}</td>
                <td>{{$member->user->phone}}</td>
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
                    <button class="btn btn-danger btn-circle delete" data-id="{{$member->id}}" data-name="{{$member->user->name}}" data-url="{{route('member.delete', [$group->id, $member->id])}}"><i class="fas fa-trash"></i></button>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="confirmModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel" style="text-align: center">Xác nhận xóa?</h5>
                </div>
                    <div class="modal-body">
                        <h3 id="message" style="text-align: center"></h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancel"> Không</button>
                        <button type="button" class="btn btn-danger" id="btn-delete" data-idGroup="{{$group->id}}"> Có</button>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // =====================================AJAX DELETE====================================
            var member_id;
            var rowDelete;
            $('#list-member').on('click', '.delete', function(){
                rowDelete = this;
                member_id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                $('h3#message').html("Bạn có thật sự muốn xóa thành viên <strong>"+name+"</strong>?");
                $('#confirmModal').modal('show');
            });
            $('#btn-delete').click(function (){
                var idGroup = $('#btn-delete').attr('data-idGroup');
                var url = "/admin/group/"+idGroup+"/delMember/"+member_id;
                // console.log(url);

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response) {
                        console.log(response);
                        if(response.data == 0){
                            $(rowDelete).closest("tr").remove();
                            $('#confirmModal').modal('hide');
                            toastr.success('Bạn đã xóa thành công thành viên <strong>'+response.name+'</strong>', 'Success')
                        } else{
                            $('.modal-body').text('Xóa thất bại!');
                            $('#btn-cancel').text('Cancel');
                        }
                    }
                });
            });
        });
        // =====================================AJAX DELETE====================================



    </script>
@endsection
