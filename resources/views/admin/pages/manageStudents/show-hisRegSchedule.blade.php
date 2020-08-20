@extends('admin.layout.index')
@section('style')
    <style>
        tr, td{
            font-size: 110%;
        }
    </style>
@endsection
@section('content')
    <h1>Lịch sử thực tập của sinh viên <strong>{{$name}}</strong></h1>
    <table class="table table-striped table-bordered table-hover" id="example">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Tên task</th>
                <th>Ghi chú</th>
                <th>Thời gian check-in</th>
                <th>Thời gian check-out</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checks as $check)
                <tr class="odd gradeX" align="center">
                    <td>{{$check->id}}</td>
                    <td>{{$check->task->name}}</td>
                    <td>{{$check->note}}</td>
                    <td>
                        {{\Carbon\Carbon::parse($check->schedule->date)->isoFormat('D/M')}}
                        @switch(\Carbon\Carbon::parse($check->schedule->date)->isoFormat('dddd'))
                            @case('Monday')
                            - <span class="badge badge-primary">Thứ 2</span> -
                            @break
                        @case('Tuesday')
                            - <span class="badge badge-primary">Thứ 3</span> -
                            @break
                        @case('Wednesday')
                            - <span class="badge badge-primary">Thứ 4</span> -
                            @break
                        @case('Thursday')
                            - <span class="badge badge-primary">Thứ 5</span> -
                            @break
                        @case('Friday')
                            - <span class="badge badge-primary">Thứ 6</span> -
                            @break
                        @default

                    @endswitch
                    <span class="badge badge-info">{{\Carbon\Carbon::parse($check->schedule->date)->toTimeString()}}</span>
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($check->date)->isoFormat('M/D')}}
                        @switch(\Carbon\Carbon::parse($check->date)->isoFormat('dddd'))
                            @case('Monday')
                                - <span class="badge badge-danger">Thứ 2</span> -
                                @break
                            @case('Tuesday')
                                - <span class="badge badge-danger">Thứ 3</span> -
                                @break
                            @case('Wednesday')
                                - <span class="badge badge-danger">Thứ 4</span> -
                                @break
                            @case('Thursday')
                                - <span class="badge badge-danger">Thứ 5</span> -
                                @break
                            @case('Friday')
                                - <span class="badge badge-danger">Thứ 6</span> -
                                @break
                            @default

                        @endswitch
                        <span class="badge badge-info">{{\Carbon\Carbon::parse($check->date)->toTimeString()}}</span>
                    </td>
                    <td class="center">
                        <a href="#" class="btn btn-info btn-circle">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
