@extends('admin.layout.index')
@section('content')
    <h1 style="text-align: center">Lịch thực tập của sinh viên <strong style="color: red">{{$studentName}}</strong></h1>
    <table class="table table-striped table-bordered table-hover mt-5" id="example">
        <thead>
            <tr align="center" >
                <th>ID</th>
                <th>Ngày đăng ký thực tập</th>
                <th>Ca làm</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($arrayDayOfWeek as $key => $value)
                <tr class="odd gradeX" align="center">
                    <td>{{ ++$index }}</td>
                    <td>
                        @if ($key == 'Monday')
                            Thứ 2
                        @elseif($key == 'Tuesday')
                            Thứ 3
                        @elseif($key == 'Wednesday')
                            Thứ 4
                        @elseif($key == 'Thursday')
                            Thứ 5
                        @elseif($key == 'Friday')
                            Thứ 6
                        @endif
                    </td>
                    <td>
                        @if ($value['session']==0)
                            Cả ngày
                        @elseif($value['session']==1)
                            Ca sáng
                        @else
                            Ca chiều
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
