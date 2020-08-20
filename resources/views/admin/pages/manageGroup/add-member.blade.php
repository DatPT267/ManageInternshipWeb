@extends('admin.layout.index')
@section('content')
<h1>Thêm thành viên vào nhóm <strong>{{session('nameGroup')}}</strong></h1>
@if (session('success'))
<div class="alert alert-success">
    {!! session('success') !!}
    {{-- {{session('success')}} --}}
</div>
@endif
<table class="table table-striped table-bordered table-hover" id="example">
    <thead>
        <tr align="center">
            <th>ID</th>
            <th>Ảnh đại diện</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
            @if ($student->position == 0)
            <tr class="odd gradeX" align="center">
                <td>{{$student->id}}</td>
                <td>
                    <img src="/storage/{{$student->image}}" width="100px" height="100px">
                </td>
                <td>{{$student->name}}</td>
                <td>{{$student->email}}</td>
                <td>{{$student->address}}</td>
                <td>{{$student->phone}}</td>
                <td class="center">
                    <a href="/admin/group/{{$group}}/add-member/{{$student->id}}"><i class="fas fa-plus"></i> Thêm</a>
                </td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>

@endsection
