@extends('user.layout.index')
@section('content')
    <div style="margin: 20px 10%;">
        <h1 style="text-align: center; margin-bottom: 20px">Thông tin nhóm của sinh viên</h1>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h4 class="mb-0">Tên nhóm</h4>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{$group->name}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h4 class="mb-0">Đợt thực tập</h4>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{$group->internshipClass->name}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h4 class="mb-0">Topic</h4>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{$group->topic}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h4 class="mb-0">Trạng thái</h4>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            @if ($group->status == 0)
                            <button class="btn btn-success">Hoạt động</button>
                            @else
                            <button class="btn btn-danger">Không hoạt động</button>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-2">
                            <h4 class="mb-0">Danh sách sinh viên</h4>
                        </div>
                        <div class="col-sm-10 text-secondary">
                            <table class="table table-striped table-bordered table-hover" id="example">
                                <thead>
                                    <tr align="center">
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Vị trí</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                    <tr class="odd gradeX" align="center">
                                        <td>{{$member->user->id}}</td>
                                        <td>{{$member->user->name}}</td>
                                        <td>
                                            @if ($member->user->position == 0)
                                                Thành viên
                                            @elseif($member->user->position == 1)
                                                Nhóm trưởng
                                            @else
                                                GVHD
                                            @endif
                                        </td>
                                        <td class="center">
                                            <button class="btn btn-primary btn-show" data-url="{{route('infoUser', $member->user->id)}}" data-toggle="modal" data-target=".bd-example-modal-lg">Thông tin</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title" id="exampleModalLongTitle" style="text-align: center">Thông tin sinh viên</h2>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <img id="img" src="" alt="" width="300px">
                                </div>
                                <div class="col-md-7">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td width="30%"><label><strong>Tên</strong></label></td>
                                                <td id="name">example</td>
                                            </tr>
                                            <tr>
                                                <td width="30%"><label><strong>Email</strong></label></td>
                                                <td id="email">example</td>
                                            </tr>
                                            <tr>
                                                <td width="30%"><label><strong>Địa Chỉ</strong></label></td>
                                                <td id="address">example</td>
                                            </tr>
                                            <tr>
                                                <td width="30%"><label><strong>Số điện thoại</strong></label></td>
                                                <td id="phone">example</td>
                                            </tr>
                                            <tr>
                                                <td width="30%"><label><strong>Vị trí</strong></label></td>
                                                <td id="position">example</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Large modal -->
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );

    $('.btn-show').click(function(){
       var url = $(this).attr('data-url');
    //    console.log(url);
        $.ajax({
            type: 'get',
            url: url,
            success: function(response){
                $('td#name').text(response.data.name)
                $('td#email').text(response.data.email)
                $('td#address').text(response.data.address)
                $('td#phone').text(response.data.phone)
                if(response.position == 0) $('td#position').text('Thành viên')
                else if(response.position == 1) $('td#position').text('Nhóm trưởng')
                else $('td#position').text('GVHD')

                var img = document.getElementById('img');
                img.src = "image/user/"+ response.data.image
            }
        });
    });
</script>
@endsection
