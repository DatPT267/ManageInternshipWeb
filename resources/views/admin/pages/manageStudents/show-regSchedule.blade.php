@extends('admin.layout.index')
@section('content')
    <h1 style="text-align: center">Lịch thực tập của sinh viên <strong style="color: red">{{$studentName}}</strong></h1>
    {{-- <table class="table table-striped table-bordered table-hover mt-5" id="list-schedule">
        <thead>
            <tr align="center" >
                <th>Ngày đăng ký thực tập</th>
                <th>Ca làm</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($arrayDayOfWeek as $key => $value)
                <tr class="odd gradeX" align="center">
                    @if (\Carbon\Carbon::parse($key)->englishDayOfWeek == 'Monday')
                        <td>
                            <h3><span class="badge badge-primary">
                                Thứ 2 | {{\Carbon\Carbon::parse($key)->isoFormat('D-M-Y')}}
                            </span></h3>
                        </td>
                        <td>
                            @if ($value['session']==0)
                                <h3><span class="badge badge-success">Cả ngày</span></h3>
                            @elseif($value['session']==1)
                                <h3><span class="badge badge-info">Ca sáng</span></h3>
                            @else
                                <h3><span class="badge badge-warning">Ca chiều</span></h3>
                            @endif
                        </td>
                    @elseif(\Carbon\Carbon::parse($key)->englishDayOfWeek == 'Tuesday')
                        <td>
                            <h3><span class="badge badge-primary">
                                Thứ 3 | {{\Carbon\Carbon::parse($key)->isoFormat('D-M-Y')}}
                            </span></h3>
                        </td>
                        <td>
                            @if ($value['session']==0)
                                <h3><span class="badge badge-success">Cả ngày</span></h3>
                            @elseif($value['session']==1)
                                <h3><span class="badge badge-info">Ca sáng</span></h3>
                            @else
                                <h3><span class="badge badge-warning">Ca chiều</span></h3>
                            @endif
                        </td>
                    @elseif(\Carbon\Carbon::parse($key)->englishDayOfWeek == 'Wednesday')
                        <td>
                            <h3><span class="badge badge-primary">
                                Thứ 4 | {{\Carbon\Carbon::parse($key)->isoFormat('D-M-Y')}}
                            </span></h3>
                        </td>
                        <td>
                            @if ($value['session']==0)
                                <h3><span class="badge badge-success">Cả ngày</span></h3>
                            @elseif($value['session']==1)
                                <h3><span class="badge badge-info">Ca sáng</span></h3>
                            @else
                                <h3><span class="badge badge-warning">Ca chiều</span></h3>
                            @endif
                        </td>
                    @elseif(\Carbon\Carbon::parse($key)->englishDayOfWeek == 'Thursday')
                        <td>
                            <h3><span class="badge badge-primary">
                                Thứ 5 | {{\Carbon\Carbon::parse($key)->isoFormat('D-M-Y')}}
                            </span></h3>
                        </td>
                        <td>
                            @if ($value['session']==0)
                                <h3><span class="badge badge-success">Cả ngày</span></h3>
                            @elseif($value['session']==1)
                                <h3><span class="badge badge-info">Ca sáng</span></h3>
                            @else
                                <h3><span class="badge badge-warning">Ca chiều</span></h3>
                            @endif
                        </td>
                    @elseif(\Carbon\Carbon::parse($key)->englishDayOfWeek == 'Friday')
                        <td>
                            <h3><span class="badge badge-primary">
                                Thứ 6 | {{\Carbon\Carbon::parse($key)->isoFormat('D-M-Y')}}
                            </span></h3>
                        </td>
                        <td>
                            @if ($value['session']==0)
                                <h3><span class="badge badge-success">Cả ngày</span></h3>
                            @elseif($value['session']==1)
                                <h3><span class="badge badge-info">Ca sáng</span></h3>
                            @else
                                <h3><span class="badge badge-warning">Ca chiều</span></h3>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table> --}}
    <table class="table table-striped table-bordered table-hover mt-5" id="list-schedule">
        <thead>
            <tr class="odd gradeX" align="center">
                <th>STT</th>
                <th>Ngày thực tập</th>
                <th>Ca làm</th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd gradeX">
                <th></th>
                <th style="text-align: center; color: blue; font-size: 25px; font-weight: 1000">
                    TUẦN HIỆN TẠI ({{\Carbon\Carbon::now()->startOfWeek()->isoFormat('D-M-Y')}} đến {{\Carbon\Carbon::now()->endOfWeek()->isoFormat('D-M-Y')}})
                </th>
                <th></th>
            </tr>
            @if ($arrWeek1 == null)
                <tr>
                    <th></th>
                    <th style="text-align: center; font-weight: 1000">Tuần này không đăng ký lịch thực tập</th>
                    <th></th>
                </tr>
            @else
                @foreach ($arrWeek1 as $key => $value)
                    <tr class="odd gradeX" align="center">
                        <td>{{$key}}</td>
                        @if (\Carbon\Carbon::parse($value['ngay'])->englishDayOfWeek == 'Monday')
                            <td>
                                <h3><span class="badge badge-primary">
                                    Thứ 2 | {{\Carbon\Carbon::parse($value['ngay'])->isoFormat('D-M-Y')}}
                                </span></h3>
                            </td>
                        @elseif(\Carbon\Carbon::parse($value['ngay'])->englishDayOfWeek == 'Tuesday')
                            <td>
                                <h3><span class="badge badge-primary">
                                    Thứ 3 | {{\Carbon\Carbon::parse($value['ngay'])->isoFormat('D-M-Y')}}
                                </span></h3>
                            </td>
                        @elseif(\Carbon\Carbon::parse($value['ngay'])->englishDayOfWeek == 'Wednesday')
                            <td>
                                <h3><span class="badge badge-primary">
                                    Thứ 4 | {{\Carbon\Carbon::parse($value['ngay'])->isoFormat('D-M-Y')}}
                                </span></h3>
                            </td>
                        @elseif(\Carbon\Carbon::parse($value['ngay'])->englishDayOfWeek == 'Thursday')
                            <td>
                                <h3><span class="badge badge-primary">
                                    Thứ 5 | {{\Carbon\Carbon::parse($value['ngay'])->isoFormat('D-M-Y')}}
                                </span></h3>
                            </td>
                        @elseif(\Carbon\Carbon::parse($value['ngay'])->englishDayOfWeek == 'Friday')
                            <td>
                                <h3><span class="badge badge-primary">
                                    Thứ 6 | {{\Carbon\Carbon::parse($value['ngay'])->isoFormat('D-M-Y')}}
                                </span></h3>
                            </td>
                        @endif
                        <td>
                            @if ($value['session']==0)
                                <h3><span class="badge badge-success">Cả ngày</span></h3>
                            @elseif($value['session']==1)
                                <h3><span class="badge badge-info">Ca sáng</span></h3>
                            @else
                                <h3><span class="badge badge-warning">Ca chiều</span></h3>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            <tr class="odd gradeX">
                <th></th>
                <th style="text-align: center; color: blue; font-size: 25px; font-weight: 1000">
                    TUẦN SAU ({{\Carbon\Carbon::now()->addWeek()->startOfWeek()->isoFormat('D-M-Y')}} đến {{\Carbon\Carbon::now()->addWeek()->endOfWeek()->isoFormat('D-M-Y')}})
                </th>
                <th></th>
            </tr>
            @if ($arrWeek2 !== null)
                @foreach ($arrWeek2 as $key => $value)
                    <tr class="odd gradeX" align="center">
                        <td>{{$key}}</td>
                        @if (\Carbon\Carbon::parse($value['ngay'])->englishDayOfWeek == 'Monday')
                            <td>
                                <h3><span class="badge badge-primary">
                                    Thứ 2 | {{\Carbon\Carbon::parse($value['ngay'])->isoFormat('D-M-Y')}}
                                </span></h3>
                            </td>
                        @elseif(\Carbon\Carbon::parse($value['ngay'])->englishDayOfWeek == 'Tuesday')
                            <td>
                                <h3><span class="badge badge-primary">
                                    Thứ 3 | {{\Carbon\Carbon::parse($value['ngay'])->isoFormat('D-M-Y')}}
                                </span></h3>
                            </td>
                        @elseif(\Carbon\Carbon::parse($value['ngay'])->englishDayOfWeek == 'Wednesday')
                            <td>
                                <h3><span class="badge badge-primary">
                                    Thứ 4 | {{\Carbon\Carbon::parse($value['ngay'])->isoFormat('D-M-Y')}}
                                </span></h3>
                            </td>
                        @elseif(\Carbon\Carbon::parse($value['ngay'])->englishDayOfWeek == 'Thursday')
                            <td>
                                <h3><span class="badge badge-primary">
                                    Thứ 5 | {{\Carbon\Carbon::parse($value['ngay'])->isoFormat('D-M-Y')}}
                                </span></h3>
                            </td>
                        @elseif(\Carbon\Carbon::parse($value['ngay'])->englishDayOfWeek == 'Friday')
                            <td>
                                <h3><span class="badge badge-primary">
                                    Thứ 6 | {{\Carbon\Carbon::parse($value['ngay'])->isoFormat('D-M-Y')}}
                                </span></h3>
                            </td>
                        @endif
                        <td>
                            @if ($value['session']==0)
                                <h3><span class="badge badge-success">Cả ngày</span></h3>
                            @elseif($value['session']==1)
                                <h3><span class="badge badge-info">Ca sáng</span></h3>
                            @else
                                <h3><span class="badge badge-warning">Ca chiều</span></h3>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                    <tr>
                        <th></th>
                        <th>Tuần này không đăng ký lịch thực tập</th>
                        <th></th>
                    </tr>
            @endif
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
            });

            // $('button#btn-show-week').click(function (){

            //     var nameWeek = $(this).attr('data-name');
            //     console.log(nameWeek);
            //     if(nameWeek == 'after'){
            //         $(this).text('Tuần hiện tại');
            //         $(this).attr('data-name', 'current');
            //         $(this).attr('data-id', 1);
            //     }else if(nameWeek == 'current'){
            //         $(this).text('Tuần sau');
            //         $(this).attr('data-name', 'after');
            //         $(this).attr('data-id', 0);
            //     }
            //     var idShow = $(this).attr('data-id');
            //     console.log(idShow);
            //     $.ajax({
            //         type: "GET",
            //         url: "url",
            //         data: "data",
            //         dataType: "dataType",
            //         success: function (response) {

            //         }
            //     });
            // })
        })
    </script>
@endsection
