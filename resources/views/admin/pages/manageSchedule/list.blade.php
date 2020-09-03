@extends('admin.layout.index')
@section('content')
    <h1>Danh sách đăng ký thực tập trong tuần này và tuần sau</h1>
    <table class="table table-striped table-hover table-bordered" id="list-schedule">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $index => $schedule)
                <tr>
                    <td>{{$index}}</td>
                    <td>{{$schedule->user->name}}</td>
                    <td>
                        <a href="#" class="btn btn-info btn-circle" >
                            <i class="fas fa-info-circle"></i>
                          </a>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>
@endsection
