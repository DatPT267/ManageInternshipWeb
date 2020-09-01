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
                        <button type="button" class="btn btn-primary btn-show-detail" data-toggle="modal" data-target=".bd-example-modal-lg">Chi tiết</button>
                    </td>
                </tr>
            @endforeach

            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="model-header">
                            <h3 class="modal-title" style="text-align: center">Chi tiết</h3>
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
            $('.btn-show-detail').click(function (){
                $('.modal-body').html("<table class='table table-hover table-bordered table-striped'>"+
                    "<thead>"+
                        "<tr>"+
                            "<th>STT</th>"+
                            "<th>Tên Task</th>"+
                            "<th>Trạng thái</th>"
                        +"</tr>"
                    +"</thead>"
                    +"<tbody>"+
                        "<tr>"+
                            "<td>1</td>"+
                            "<td>Task 1</td>"+
                            "<td>Doing</td>"
                        +"</tr>"
                    +"</tbody>"
                +"</table>");
            })
        })
    </script>
@endsection
