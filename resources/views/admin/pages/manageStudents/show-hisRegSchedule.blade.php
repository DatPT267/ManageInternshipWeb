@extends('admin.layout.index')
@section('style')
    <style>
        tr, td{
            font-size: 110%;
        }
    </style>
@endsection
@section('content')
    <h1>Lịch sử thực tập của sinh viên <strong>{{$user->name}}</strong></h1>
    <button class="btn btn-info" id="week1" data-url="{{route('ajax.view-schedule', [$user->id, 1])}}">Tuần trước</button>
    <button class="btn btn-primary" id="week" data-url="{{route('ajax.view-schedule', [$user->id, 0])}}">Tuần hiện tại</button>
    <button class="btn btn-warning" id="week2" data-url="{{route('ajax.view-schedule', [$user->id, 2])}}">Tuần sau</button>
    <table class="table table-striped table-bordered table-hover" id="example">
        <thead>
            <tr align="center">
                <th>STT</th>
                <th>Lịch thực tập</th>
                <th>Thời gian check-in</th>
                <th>Thời gian check-out</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody id="body">
            @foreach ($checks as $check)
                <tr class="odd gradeX" align="center">
                    <td>{{$index++}}</td>
                    <td>
                        @switch(\Carbon\Carbon::parse($check->date_start)->isoFormat('dddd'))
                            @case('Monday')
                                <span class="badge badge-primary">Thứ 2</span> -
                                @break
                            @case('Tuesday')
                                <span class="badge badge-primary">Thứ 3</span> -
                                @break
                            @case('Wednesday')
                                <span class="badge badge-primary">Thứ 4</span> -
                                @break
                            @case('Thursday')
                                <span class="badge badge-primary">Thứ 5</span> -
                                @break
                            @case('Friday')
                                <span class="badge badge-primary">Thứ 6</span> -
                                @break
                            @default
                        @endswitch
                        <span class="badge badge-info">
                            {{\Carbon\Carbon::parse($check->date_start)->isoFormat('D/M/Y')}}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-info">{{\Carbon\Carbon::parse($check->date_start)->toTimeString()}}</span>
                    </td>
                    <td>
                        @if ($check->date_end != null)
                            <span class="badge badge-warning">{{\Carbon\Carbon::parse($check->date_end)->toTimeString()}}</span>
                        @else
                            <span class="badge badge-danger">Chưa check-out</span>
                        @endif
                    </td>
                    <td class="center">
                        <a href="#" class="btn btn-info btn-circle btn-show" data-toggle="modal" data-target="#exampleModalCenter" data-id="{{$check->id}}" data-url="{{route('ajax.view-task', $check->id)}}">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Thông tin chi tiết</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover" id="detail">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên task</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="show-detail">

                    </tbody>
                </table>
                <div id="note" style="display: flex">
                    <label style="flex: 1; font-size: 15px"> <strong> Note:</strong></label>
                    <p style="flex: 5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa laboriosam dicta corporis necessitatibus ea earum voluptas dolores omnis
                        aliquid consequuntur nobis saepe, autem natus? Beatae reprehenderit tenetur molestias provident iusto.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            // $('#week').attr('disabled','disabled');

            $('#example').dataTable({
                'paging': false,
                'info': false,
                'sort': false
            });

            function check (item){
                if(item == 0) return "<span class='badge badge-primary'>To-do</span>";
                else if(item == 1) return  "<span class='badge badge-info'>Doing</span>";
                else if(item == 2) return  "<span class='badge badge-warning'>Review</span>";
                else if(item == 3) return  "<span class='badge badge-success'>Done</span>";
                else return  "<span class='badge badge-secondary'>Pending</span>";
            }

            function formatDate(date)
            {

            }

            function callAjax(url){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response) {
                        console.log(response.data);
                        var output = "";
                        if(response.data.length == 0){
                            output = "<tr>"+
                                "<th colspan = '5' style = 'text-align: center'>Không có bản ghi</th>"
                            +"</tr>";
                            $('tbody#body').html(output);
                        }else{
                            for (var i = 0; i < response.data.length; i++) {
                                output = "<tr style = 'text-align: center'>"+
                                    "<td>"+i+"</td>"+
                                    "<td>"+response.data[i].date_start+"</td>"+
                                    "<td>"+response.data[i].date_end+"</td>"+
                                    "<td><a href='#' class='btn btn-info btn-circle btn-show' data-toggle='modal' data-target='#exampleModalCenter' data-id='"+response.data[i].id+"' data-url='{{ route('ajax.view-task', "response.data[i].id") }}'><i class='fas fa-info-circle'></i></a></td>"
                                +"</tr>";
                            }
                            $('tbody#body').html(output);
                        }
                    }
                });
            }
            // <a href="#" class="btn btn-info btn-circle btn-show" data-toggle="modal" data-target="#exampleModalCenter" data-id="{{$check->id}}" data-url="{{route('ajax.view-task', $check->id)}}">
                // <i class="fas fa-info-circle"></i>
                //         </a>
            $('#week').click(function (){
                $('#week').prop( "disabled", true );
                var url = $(this).attr('data-url');
                callAjax(url);
            });
            $('#week1').click(function (){
                $("#week").removeAttr('disabled');
                var url = $(this).attr('data-url');
                callAjax(url);
            });
            $('#week2').click(function (){
                $("#week").removeAttr('disabled');
                var url = $(this).attr('data-url');
                callAjax(url);
            });


            $('a.btn-show').click(function(){
                var id_check = $(this).attr('data-id');
                var url = $(this).attr('data-url');
                console.log(id_check);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataText: 'TEXT',
                    success: function(response){
                        var ouput = '';
                        console.log(response);
                        response.data.forEach(item => {
                            // console.log(item);
                            ouput+= "<tr>"+
                                    "<td>"+item.id+"</td>"+
                                    "<td>"+item.name+"</td>"+
                                    "<td>"+check(item.status)+"</td>"
                                +"</tr>";
                        });
                        $('#note p').text(response.note);
                        $('tbody.show-detail').html(ouput);
                    }
                })

            });
        });
    </script>
@endsection
