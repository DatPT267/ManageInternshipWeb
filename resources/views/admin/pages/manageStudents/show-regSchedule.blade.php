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
                            <h3><span class="badge badge-primary">Thứ 2</span></h3>
                        @elseif($key == 'Tuesday')
                            <h3><span class="badge badge-primary">Thứ 3</span></h3>
                        @elseif($key == 'Wednesday')
                            <h3><span class="badge badge-primary">Thứ 4</span></h3>
                        @elseif($key == 'Thursday')
                            <h3><span class="badge badge-primary">Thứ 5</span></h3>
                        @elseif($key == 'Friday')
                            <h3><span class="badge badge-primary">Thứ 6</span></h3>
                        @elseif($key == 'Saturday')
                            <h3><span class="badge badge-warning">Thứ 7</span></h3>
                        @elseif($key == 'Sunday')
                            <h3><span class="badge badge-warning">Chủ nhật</span></h3>
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
