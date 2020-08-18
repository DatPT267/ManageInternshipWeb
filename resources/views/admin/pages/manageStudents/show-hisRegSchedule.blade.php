@extends('admin.layout.index')
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
                    <td>{{$check->date}}</td>
                    <td>{{$check->schedule->date}}</td>
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
