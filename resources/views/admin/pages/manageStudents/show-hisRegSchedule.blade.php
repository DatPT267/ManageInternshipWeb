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
                    <td id="index">{{$index++}}</td>
                    <td id="lichthuctap">
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
                    <td id="checkin">
                        <span class="badge badge-info">{{\Carbon\Carbon::parse($check->date_start)->toTimeString()}}</span>
                    </td>
                    <td id="checkout">
                        @if ($check->date_end != null)
                            <span class="badge badge-warning">{{\Carbon\Carbon::parse($check->date_end)->toTimeString()}}</span>
                        @else
                            <span class="badge badge-danger">Chưa check-out</span>
                        @endif
                    </td>
                    <td class="center" id="btn-detail">
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

            $('#example').dataTable({
                "scrollY" : "50vh",
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

            $('a.btn-show').click(function(){
                var id_check = $(this).attr('data-id');
                var url = $(this).attr('data-url');
                // console.log(id_check);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataText: 'TEXT',
                    success: function(response){
                        var ouput = '';
                        console.log(response);
                        response.data.forEach(item => {
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
