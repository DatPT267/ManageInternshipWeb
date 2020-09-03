@extends('admin.layout.index')
@section('content')
    <h1>statistical Checkin - out</h1>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Đợt thực tập</th>
                <th>Thông tin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checks as $index => $check)
                <tr>
                    <td>{{$index}}</td>
                    <td>{{$check->user->name}}</td>
                    <td>{{$check->user->internshipClass->name}}</td>
                    <td>
                        <a href="{{route('detail.checkin-checkout', $check->user_id)}}" class="btn btn-info btn-circle">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
