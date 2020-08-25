@extends('admin.layout.index')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách bài tập nhóm</h1>
</div>

@if (session('success'))
    <div class="alert alert-success">
        <strong>{{session('success')}}</strong>
    </div>
@endif
@if (session('fail'))
    <div class="alert alert-danger">
        <strong>{{session('fail')}}</strong>
    </div>
@endif
<table class="table table-striped table-bordered table-hover" id="example">
    <thead>
        <tr align="center">
            <th>Tên bài tập</th>
            <th>Ghi nhớ</th>
            <th>Trạng thái</th>
            <th>Hoạt động</th>
        </tr>
    </thead>
</table>
@endsection
