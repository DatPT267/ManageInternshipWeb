:@extends('user.layout.index')
@section('content')
<div style="margin: 20px 30%;">
    <h1 style="text-align: center; margin-bottom: 20px">Xem lịch sử checkin - checkout</h1>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Lịch thực tập</th>
                <th>Thời gian check-in</th>
                <th>Thời gian check-out</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checks as $key => $check)
                <tr>
                    <td>{{$key}}</td>
                    <td>
                        @switch(\Carbon\Carbon::parse($check->schedule->date)->isoFormat('dddd'))
                            @case('Monday')
                                Thứ 2
                                @break
                            @case('Tuesday')
                                Thứ 3
                                @break
                            @case('Wednesday')
                                Thứ 4
                                @break
                            @case('Thursday')
                                Thứ 5
                                @break
                            @case('Friday')
                                Thứ 6
                                @break
                            @default

                        @endswitch -
                        {{\Carbon\Carbon::parse($check->schedule->date)->format('d-m-Y')}}
                    </td>
                    <td>{{\Carbon\Carbon::parse($check->date_start)->isoFormat('HH:mm:ss')}}</td>
                    <td>
                        @if ($check->date_end != null)
                            {{\Carbon\Carbon::parse($check->date_end)->isoFormat('HH:mm:ss')}}
                        @else
                            Chưa check-out
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-show-detail" data-url="{{route('ajax.His-schedule', $check->id)}}" data-toggle="modal" data-target=".bd-example-modal-lg">Chi tiết</button>
                    </td>
                </tr>
            @endforeach

            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="model-header">
                            <h3 class="modal-title" style="text-align: center">Thông tin chi tiết</h3>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Tổng thời gian làm việc:</th>
                <th colspan="2">{{$ngay}} ngày {{$gio}} giờ {{$phut}} phút</th>
            </tr>
        </tfoot>
    </table>
    <!-- Large modal -->

</div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            function checkStatus(status)
            {
                if(status == 0){
                    return "<span class='badge badge-secondary'>To do</span>";
                } else if(status == 1){
                    return "<span class='badge badge-info'>Doing</span>";
                }else if(status == 2){
                    return "<span class='badge badge-warning'>Review</span>";
                }else if(status == 3){
                    return "<span class='badge badge-success'>Done</span>";
                }else if(status == 4){
                    return "<span class='badge badge-primary'>Pending</span>";
                }
            }

            $('.btn-show-detail').click(function (){
                var url = $(this).attr('data-url');
                console.log(url);
                $.ajax({
                    type: "GET",
                    url: url,
                    datatype: 'TEXT',
                    success: function (response) {
                        console.log(response.note);
                        var output  = "";
                        response.data.forEach(item => {
                            output += "<tr>"+
                                "<td>"+item.id+"</td>"+
                                "<td>"+item.name+"</td>"+
                                "<td>"+checkStatus(item.status)+"</td>"
                            +"</tr>";
                        });
                        $('.modal-body').html("<table class='table table-hover table-bordered table-striped'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th>STT</th>"+
                                    "<th>Tên Task</th>"+
                                    "<th>Trạng thái</th>"
                                +"</tr>"
                            +"</thead>"
                            +"<tbody>"+
                                output
                            +"</tbody>"
                        +"</table>"+
                        "<strong>Note</strong>: "+response.note);
                    }
                });
            })
        })
    </script>
@endsection