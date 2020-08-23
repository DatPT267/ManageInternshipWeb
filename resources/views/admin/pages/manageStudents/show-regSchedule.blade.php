@extends('admin.layout.index')
@section('content')
    <h1 style="text-align: center">Lịch thực tập của sinh viên <strong style="color: red">{{$studentName}}</strong></h1>
    <table class="table table-striped table-bordered table-hover mt-5" id="example">
        <thead>
            <tr align="center" >
                <th>STT</th>
                <th>Ngày đăng ký thực tập</th>
                <th>Ca làm</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($arrayDayOfWeek as $key => $value)
                <tr class="odd gradeX" align="center">
                    <td>{{ $index++ }}</td>
                    <td>
                        @if (\Carbon\Carbon::parse($key)->englishDayOfWeek == 'Monday')
                            <h3><span class="badge badge-primary">
                                {{\Carbon\Carbon::parse($key)->isoFormat('D-M-Y')}} | Thứ 2
                            </span></h3>
                        @elseif(\Carbon\Carbon::parse($key)->englishDayOfWeek == 'Tuesday')
                            <h3><span class="badge badge-primary">
                                {{\Carbon\Carbon::parse($key)->isoFormat('D-M-Y')}} | Thứ 3
                            </span></h3>
                        @elseif(\Carbon\Carbon::parse($key)->englishDayOfWeek == 'Wednesday')
                            <h3><span class="badge badge-primary">
                                {{\Carbon\Carbon::parse($key)->isoFormat('D-M-Y')}} | Thứ 4
                            </span></h3>
                        @elseif(\Carbon\Carbon::parse($key)->englishDayOfWeek == 'Thursday')
                            <h3><span class="badge badge-primary">
                                {{\Carbon\Carbon::parse($key)->isoFormat('D-M-Y')}} | Thứ 5
                            </span></h3>
                        @elseif(\Carbon\Carbon::parse($key)->englishDayOfWeek == 'Friday')
                            <h3><span class="badge badge-primary">
                                {{\Carbon\Carbon::parse($key)->isoFormat('D-M-Y')}} | Thứ 6
                            </span></h3>
                        @endif
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
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
