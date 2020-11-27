@extends('admin.layout.index')
@section('content')
    <a href="{{ route('group.listMember', $group->id) }}" class="btn btn-secondary">Trở về</a>
    <h1>Thêm thành viên vào nhóm <strong>{{$group->name}}</strong></h1>
    <table class="table table-striped table-bordered table-hover" id="list-member">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh đại diện</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $key => $student)
                <tr class="odd gradeX">
                    <td>{{$key+1}}</td>
                    <td>
                        @if ($student->image != null)
                            <img src="{{ asset('/image/user/'.$student->image) }}" width="100px" height="100px">
                        @else
                            <img src="{{ asset('/image/user/avatar.jpg') }}" width="100px" height="100px">
                        @endif
                    </td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->email}}</td>
                    <td>{{$student->address}}</td>
                    <td>{{$student->phone}}</td>
                    <td class="center">
                        <button class="btn btn-success btn-addmember" data-url="{{route('post.add-member', [$group->id, $student->id])}}" data-id="{{$student->id}}" data-name="{{$student->name}}" data-name-group="{{$group->name}}"><i class="fas fa-plus"></i> Thêm</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade bd-example-modal-lg" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Xác nhận thêm?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addmember">
                    <div class="alert alert-warning message2"></div>
                    <div class="modal-body">
                        <div style="display: flex; margin-bottom: 20px">
                            <input type="text" id="id_member" value="" hidden>
                            <label style="flex: 1; margin-top: 3px">Chức vụ: </label>
                            <select name="position" id="position" style="flex: 5" class="form-control">
                                <option value="0" selected>Thành viên</option>
                                <option value="1">Nhóm trưởng</option>
                            </select>
                        </div>
                        <h3 style="text-align: center" id="message">Bạn muốn thêm thành viên vào nhóm</h3>
                    </div>
                    <div class="modal-body-2"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-add">Có</button>
                        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Không</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            function check(postion){
                if(postion == '0'){
                    return  'Thành viên';
                } else if(postion == '1'){
                    return 'Nhóm trưởng';
                }else{
                    return 'GVHD';
                }
            }
            var url;
            var rowDelete;
            $('.btn-addmember').click(function(){
                rowDelete = this;
                url = $(this).attr('data-url');
                $('#confirmModal').modal('show');
                $('.message2').hide();
                var id = $(this).attr('data-id');
                $('#id_member').val(id);
                var name = $(this).attr('data-name');
                var name_group = $(this).attr('data-name-group');
                $('#message').html("Bạn muốn thêm thành viên <strong>"+name+"</strong> vào nhóm <strong>"+name_group+"</strong>");
            });


            $('#addmember').on('submit', function (e) {
                e.preventDefault();
                var position = check($('#position option:selected').val());
                console.log(url);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: url,
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log(response.data);
                        if(response.data == 0 && response.position == 0){
                            $(rowDelete).closest("tr").remove();
                            $('#confirmModal').modal('hide');
                            toastr.success('Bạn đã thêm thành công '+position+' <strong>'+response.name+'</strong>', 'Success')
                        }else if(response.data == 1 && response.position == 1){
                            $('.btn-add').prop('disabled', false);
                            $('.message2').show();
                            $('.modal-body').show();
                            $('.message2').text("Nhóm đã có "+position+"!!!");
                            $('.modal-body-2').hide();
                            $('.btn-close').show();
                        }
                    }
                });
            });
        })
    </script>
@endsection
