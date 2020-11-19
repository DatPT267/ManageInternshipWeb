@extends('admin.layout.index')
@section('content')
<div class="container-fluid">
    <h1>Danh sách thành viên của <strong>{{$internshipClass->name}}</strong></h1>
    <a href="{{ route('internshipClass.index') }}" class="btn btn-light btn-icon-split">
        <span class="icon text-gray-600">
        <i class="fas fa-arrow-left"></i>
        Trở về
        </span>
    </a>
    <table class="table table-striped table-bordered table-hover" id="list-member">
        <thead>
            <tr >
                <th>STT</th>
                <th>Tên</th>
                <th>Ảnh hiển thị</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>

            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            @foreach ($students as $student)
            <tr class="odd gradeX" >
                <td>{{$index++}}</td>
                <td>{{$student->name}}</td>
                <td>
                @if($student->image == null)
                    <img src="{{asset('image/user/avatar.jpg')}}" width="100px" height="100px">
                @else
                    <img src="{{asset('image/user')}}/{{$student->image}}" width="100px" height="100px">
                @endif
                </td>
                <td>{{$student->email}}</td>
                <td>{{$student->address}}</td>
                <td>{{$student->phone}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
