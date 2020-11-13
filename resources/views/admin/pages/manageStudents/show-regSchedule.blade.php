@extends('admin.layout.index')
@section('style')
    <style>
        tr, td{
            font-size: 20px;
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <a href="{{url()->previous()}}" class="btn btn-light btn-icon-split">
        <span class="icon text-gray-600">
        <i class="fas fa-arrow-left"></i>
        Trở về
        </span>
    </a>
    <h1 style="text-align: center">Lịch thực tập của sinh viên <strong style="color: red">{{$name}}</strong></h1>
    <button class="btn btn-light btn-icon-split" id="btn-before">
        <span class="icon text-gray-600">
            <i class="fas fa-arrow-left"></i>
        </span>
    </button>
    Tuần <input type="text" id="week"
                            style="text-align: center; width: 3rem"
                            value="{{ $week }}"
                            data-month="{{$month}}"
                            data-url="{{route('ajax.schedule')}}"
                            data-week="{{$numberWeekOfMonth}}"
                            data-id="{{$id}}"
                            disabled>
    <button class="btn btn-light btn-icon-split" id="btn-after">
        <span class="icon text-gray-600">
            <i class="fas fa-arrow-right"></i>
        </span>
    </button>
    <table class="table table-striped table-bordered table-hover mt-5" id="list-schedule">
        <thead>
            <tr class="odd gradeX" align="center">
                <th>STT</th>
                <th>Ngày thực tập</th>
                <th>Ca làm</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($schedules as $index => $schedule)
                <tr>
                    <td>{{++$i}}</td>
                    @switch(\Carbon\Carbon::parse($schedule->date)->englishDayOfWeek)
                        @case('Monday')
                            <td>
                                <span class="badge badge-primary">Thứ 2</span>
                                | <span class="badge badge-info">{{\Carbon\Carbon::parse($schedule->date)->isoFormat('DD-MM-YYYY')}}</span>
                            </td>
                            @break
                        @case('Wednesday')
                            <td>
                                <span class="badge badge-primary">Thứ 3</span>
                                | <span class="badge badge-info">{{\Carbon\Carbon::parse($schedule->date)->isoFormat('DD-MM-YYYY')}}</span>
                            </td>
                            @break
                        @case('Tuesday')
                            <td>
                                <span class="badge badge-primary">Thứ 4</span>
                                | <span class="badge badge-info">{{\Carbon\Carbon::parse($schedule->date)->isoFormat('DD-MM-YYYY')}}</span>
                            </td>
                            @break
                        @case('Thursday')
                            <td>
                                <span class="badge badge-primary">Thứ 5</span>
                                | <span class="badge badge-info">{{\Carbon\Carbon::parse($schedule->date)->isoFormat('DD-MM-YYYY')}}</span>
                            </td>
                            @break
                        @case('Friday')
                            <td>
                                <span class="badge badge-primary">Thứ 6</span>
                                | <span class="badge badge-info">{{\Carbon\Carbon::parse($schedule->date)->isoFormat('DD-MM-YYYY')}}</span>
                            </td>
                            @break
                        @default
                    @endswitch
                    <td>
                        @if ($schedule->session == 0)
                            <span class="badge badge-success">Cả ngày</span>
                        @elseif($schedule->session == 1)
                            <span class="badge badge-info">Ca sáng</span>
                        @else
                            <span class="badge badge-warning">Ca chiều</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('#list-schedule').dataTable({
                'info': false,
                'order': false,
                'paging': false,
                "bLengthChange": false,
                "searching": false,
                "language": {
                    "emptyTable": "Tuần này không đăng ký thực tập"
                }
            });

            function checkDay(day){
                switch (day) {
                    case 'Monday':
                        return "<span class='badge badge-primary'>Thứ 2</span> |";
                        break;
                    case 'Wednesday':
                        return "<span class='badge badge-primary'>Thứ 3</span> |";
                        break;
                    case 'Tuesday':
                        return "<span class='badge badge-primary'>Thứ 4</span> |";
                        break;
                    case 'Thursday':
                        return "<span class='badge badge-primary'>Thứ 5</span> |";
                        break;
                    case 'Friday':
                        return "<span class='badge badge-primary'>Thứ 6</span> |";
                        break;
                }
            }
            function checkSession(session){
                switch (session) {
                    case 0:
                        return "<span class='badge badge-success'>Cả ngày</span>";
                        break;
                    case 1:
                        return "<span class='badge badge-info'>Ca sáng</span>";
                        break;
                    case 2:
                        return "<span class='badge badge-warning'>Ca chiều</span>";
                        break;

                }
            }
            //========================AJAX==============================
            function ajax(url, month, week, id){
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        month: month,
                        week: week,
                        id: id
                    },
                    success: function (response) {
                        console.log(response);
                        var output = "";
                        var index = 0;
                        if(response.data.length != 0){
                            for (let i = 0; i < response.data.length; i++) {
                                index++;
                                output += "<tr>"+
                                    "<td>"+ index +"</td>"+
                                    "<td>"+checkDay(response.data[i].englishDayOfWeek)+" <span class='badge badge-info'>"+response.data[i].date+"</span>"+"</td>"+
                                    "<td>"+checkSession(response.data[i].session)+"</td>"
                                +"</tr>";
                            }
                        } else{
                            output = "<tr><th colspan='3'>Tuần này không đăng ký thực tập</th></tr>";
                        }
                        $('tbody').html(output);
                    }
                });
            }
            //========================AJAX==============================
            $('#btn-before').click(function (){
                $('#btn-after').attr('disabled', false);
                if( $('#week').val() > 1 ){
                    $('#week').val( $('#week').val() - 1);
                    var week = $('#week').val();
                    var month = $('#week').attr('data-month');
                    var id = $('#week').attr('data-id');
                    var url = $('#week').attr('data-url');
                    ajax(url, month, week, id);
                }
                if($('#week').val() == 1){
                    $('#btn-before').attr('disabled', true);
                }
            })
            $('#btn-after').click(function (){
                $('#btn-before').attr('disabled', false);
                var numberWeek = $('#week').attr('data-week');
                console.log(numberWeek);
                if( $('#week').val() < numberWeek ){
                    $('#week').val( parseInt($('#week').val()) + 1);
                    var week = $('#week').val();
                    var month = $('#week').attr('data-month');
                    var id = $('#week').attr('data-id');
                    var url = $('#week').attr('data-url');
                    ajax(url, month, week, id);
                }
                if($('#week').val() == numberWeek){
                    $('#btn-after').attr('disabled', true);
                }
            })
        })
    </script>
@endsection
