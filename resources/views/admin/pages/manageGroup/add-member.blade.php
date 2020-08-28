@extends('admin.layout.index')
@section('content')
<h1>Thêm thành viên vào nhóm <strong>{{session('nameGroup')}}</strong></h1>
@if (session('success'))
<div class="alert alert-success">
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
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $key => $student)
            <tr class="odd gradeX" align="center">
                <td>{{$key}}</td>
                <td>
                    <img src="/image/user/{{$student->image}}" width="100px" height="100px">
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
                                <option value="2">GVHD</option>
                            </select>
                        </div>
                        <h3 style="text-align: center" id="message">Bạn muốn thêm thành viên vào nhóm</h3>
                    </div>
                    <div class="modal-body-2"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Không, Thoát</button>
                        <button type="submit" class="btn btn-primary btn-add">Đúng, Thêm vào</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#list-member').DataTable({
            'info': false
        });
        function check(postion){
            if(postion == '0'){
                return  'Thành viên';
            } else if(postion == '1'){
                return 'Nhóm trưởng';
            }else{
                return 'GVHD';
            }
        }
        $(document).ready(function (){
            var url = $('.btn-addmember').attr('data-url');
            // console.log(url);
            $('.btn-addmember').click(function(){
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
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: url,
                    data: $(this).serialize(),
                    beforeSend:function(){
                        $('.message2').hide();
                        $('.btn-add').text('Adding ....');
                        $('.btn-add').prop('disabled', true);
                        $('.btn-close').hide();
                        $('.modal-body').hide();
                        $('.modal-body-2').show();
                        $('.modal-body-2').html('<div class="alert alert-info"> Đang thêm ......</div>');
                    },
                    success: function (response) {
                        if(response.data == 0 && response.position == 0){
                            setTimeout(() => {
                                console.log('ok');
                                $('#confirmModal').modal('show');
                                $('.modal-body').show();
                                $('.modal-body-2').hide();
                                $('.modal-body').html(
                                    '<div class="alert alert-success"> Bạn đã thêm thành công '+position+' <strong>'+response.name+'</strong></div>'
                                );
                                $('.btn-add').hide();
                                $('.btn-close').show();
                                $('.btn-close').text('Thoát');
                                $('.btn-close').click(function(){
                                    location.reload(true);
                                });
                            }, 500);
                        }else if(response.data == 1 && response.position == 1){
                            $('.btn-add').prop('disabled', false);
                            $('.message2').show();
                            $('.modal-body').show();
                            $('.message2').text("Nhóm đã có "+position+"!!!");
                            $('.btn-add').text('Đúng, thêm vào');
                            $('.modal-body-2').hide();
                            $('.btn-close').show();
                        }
                    }
                });
            });
        })
    </script>
@endsection
