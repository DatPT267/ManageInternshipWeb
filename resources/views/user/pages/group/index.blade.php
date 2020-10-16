@extends('user.layout.index')
@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <h1 style="text-align: center; margin-bottom: 20px">Thông tin nhóm của sinh viên</h1>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="mb-0 font-weight-bold">Tên nhóm</p>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        {{$group->name}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="mb-0 font-weight-bold">Đợt thực tập</p>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        {{$group->internshipClass->name}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="mb-0 font-weight-bold">Tên đề tài</p>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        {{$group->topic}}
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-2">
                        <p class="mb-0 font-weight-bold">Trạng thái</p>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        @if ($group->status == 1)
                            <span class="badge badge-success" style="padding: 10px">Hoạt động</span>
                        @else
                            <span class="badge badge-danger" style="padding: 10px">Không hoạt động</span>
                        @endif
                    </div>
                </div>
                <hr>
                {{-- ===============================================DANH SÁCH TASK================================================== --}}
                <div class="row">
                    <div class="col-sm-2">
                        <p class="mb-0 font-weight-bold">Danh sách task</p>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <button data-url="{{route('view-list-task', [$user, $group->id])}}" class="btn btn-primary btn-show-task" data-toggle="modal" data-target=".bd-example-modal-xl">Danh sách task</button>
                    </div>
                    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="exampleModalLongTitle" style="text-align: center">Danh sách task</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-striped table-bordered table-hover" id="listTask" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên task</th>
                                                <th>Trạng thái</th>
                                                <th>Thành viên tham gia</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show-task">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ===============================================DANH SÁCH TASK================================================== --}}
                <hr>
                {{-- ===============================================DANH SÁCH SINH VIÊN TRONG NHOMS================================================== --}}
                <div class="row">
                    <div class="col-sm-2">
                        <p class="mb-0 font-weight-bold">Danh sách sinh viên</p>
                    </div>
                    <div class="col-sm-10 text-secondary">
                        <table class="table table-striped table-bordered table-hover" id="example">
                            <thead>
                                <tr align="center">
                                    <th>STT</th>
                                    <th>Tên</th>
                                    <th>Vị trí</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $key => $member)
                                <tr class="odd gradeX" align="center">
                                    <td>{{$key + 1}}</td>
                                    <td>{{$member->user->name}}</td>
                                    <td>
                                        @if ($member->position == 0)
                                            Thành viên
                                        @elseif($member->position == 1)
                                            Nhóm trưởng
                                        @else
                                            GVHD
                                        @endif
                                    </td>
                                    <td class="center">
                                        <button class="btn btn-primary btn-show"
                                                data-idgroup="{{$member->group_id}}"
                                                data-url="{{route('info.member', $member->user->id)}}"
                                                data-toggle="modal"
                                                data-target=".bd-example-modal-lg">Thông tin</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="exampleModalLongTitle" >Thông tin sinh viên</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
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
                </div>
                {{-- ===============================================DANH SÁCH SINH VIÊN TRONG NHOMS================================================== --}}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        @foreach ($errors->all() as $error)
            toastr.warning("{{$error}}")
        @endforeach
    </script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                'info': false,
                "bInfo": false,
                "bLengthChange": false,
                "bFilter": true,
                "columns" : [
                    {"orderable": true},
                    {"orderable": false},
                    {"orderable": false},
                    {"orderable": false},
                ]
            });
            $('.btn-show').click(function(){
                console.log("ok");
                var url = $(this).attr('data-url');
                console.log(url);
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {group_id: $(this).attr('data-idgroup')},
                    success: function(response){
                        console.log(response);
                        $('td#name').text(response.data.name)
                        $('td#email').text(response.data.email)
                        $('td#address').text(response.data.address)
                        $('td#phone').text(response.data.phone)

                        if(response.position == 0) $('td#position').text('Thành viên')
                        else if(response.position == 1) $('td#position').text('Nhóm trưởng')
                        else $('td#position').text('GVHD')

                        var img = document.getElementById('img');
                        img.src = "{{asset('image/user')}}/"+response.data.image
                    }
                });
            });
            $('.btn-show-task').click(function (){
                var url = $(this).attr('data-url');
                console.log(url);
                $("#listTask").dataTable({
                    'destroy': true,
                    "scrollY": "50vh",
                    'info': false,
                    "scrollCollapse": true,
                    "paging": false,
                    "ajax":{
                        "url": url,
                        "type": "GET",
                        "processing": true,
                        "serverSide": true,
                        "datetype": "json"
                    },
                    "columns": [
                        {"data": "index"},
                        {"data": "name",  "orderable": false},
                        {"data": "status", "orderable": false,
                        render: function (data, type, row) {
                            if(data == 0) return "<span class='badge badge-primary' style='padding: 10px'>To-do</span>";
                            else if(data == 1) return "<span class='badge badge-info' style='padding: 10px'>Doing</span>";
                            else if(data == 2) return "<span class='badge badge-warning' style='padding: 10px'>Review</span>";
                            else if(data == 3) return "<span class='badge badge-success' style='padding: 10px'>Done</span>";
                            else return "<span class='badge badge-secondary' style='padding: 10px'>Pending</span>";
                        }},
                        {"data": "name_member", "orderable": false,
                        render: function (data, type, row) {
                            var name_member = '';
                            if(data.length > 0){
                                for (let i = 0; i < data.length; i++) {
                                    name_member += data[i] + "<br>";
                                }
                                return name_member;
                            } else{
                                return '<strong>Chưa ai nhận task</strong>';
                            }
                        }},
                        {"data": "note", "width": "40%", "orderable": false},
                    ]

                });
            });
        });



    </script>
@endsection
