@extends('admin.layout.index')
@section('content')
    <h1>Danh sách thành viên nhóm <strong>{{$group->name}}</strong></h1>
    @if (session('success'))
        <div class="alert alert-danger">
            {!! session('success') !!}
            {{-- {{session('success')}} --}}
        </div>
    @endif
    <table class="table table-striped table-bordered table-hover" id="list-member">
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
                <td>{{$index++}}</td>
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
                    <button class="btn btn-danger btn-circle delete" id="{{$member->id}}" data-name="{{$member->user->name}}" data-url="{{route('member.delete', [$group->id, $member->id])}}"><i class="fas fa-trash"></i></button>
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
                <form id="deleteMember">
                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                    @method('DELETE')
                    <div class="modal-body">
                        <input type="text" id="idmember" value="" hidden>
                        <h3 id="message" style="text-align: center"></h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancel"><i class="far fa-window-close"></i> No, cancel</button>
                        <button type="submit" class="btn btn-danger" name="btn-delete" id="btn-delete" data-idGroup="{{$group->id}}"> <i class="fas fa-trash-alt" ></i>Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#list-member').DataTable();
            // =====================================AJAX DELETE====================================
            var member_id;
            $(document).on('click', '.delete', function(){
                member_id = $(this).attr('id');
                $('#idmember').val(member_id);
                var name = $(this).attr('data-name');
                $('h3#message').html("Bạn có thật sự muốn xóa thành viên <strong>"+name+"</strong>?");
                $('#confirmModal').modal('show');
            });
            $('#deleteMember').on('submit', function(e){
                e.preventDefault();

                var id = $('#idmember').val();
                var idGroup = $('#btn-delete').attr('data-idGroup');
                var url = $('.delete').attr('data-url');
                var token = $('#_token').val();
                console.log(url);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: url,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $('#btn-delete').prop('disabled', true);
                        $('#btn-delete').text('Deleting ......');
                        $('#btn-cancel').hide();
                        $('.modal-body').html('<div class="alert alert-danger">Đang xóa ........</div>');
                    },
                    success: function (response) {
                        console.log(response);
                        if(response.data == 0){
                            setTimeout(() => {
                                $('#confirmModal').modal('show');
                                $('.modal-body').html(
                                    '<div class="alert alert-success"> Bạn đã xóa thành công thành viên <strong>'+response.name+'</strong></div>'
                                );
                                $('#btn-delete').hide();
                                $('#btn-cancel').show();
                                $('#btn-cancel').text('Cancel');
                                $('#btn-cancel').click(function (){
                                    window.location.reload(true);
                                });
                            }, 500);
                        } else{
                            $('.modal-body').text('Xóa thất bại!');
                            $('#btn-cancel').text('Cancel');
                        }
                    }
                });
            });
            // =====================================AJAX DELETE====================================
        } );



    </script>
@endsection
