@extends('admin.layout.index')
@section('content')
    <h1>Danh sách Review của nhóm <strong>{{$nameGroup}}</strong></h1>
    <table class="table table-striped table-bordered table-hover" id="example">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Tên task</th>
                <th>Tên group</th>
                <th>Nội dung</th>
                <th>Người đánh giá</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($review as $r)
            <tr class="odd gradeX" align="center">
                <td>{{$r->id}}</td>
                <td>{{$r->task->name}}</td>
                <td>{{$r->group->name}}</td>
                <td>{{$r->content}}</td>
                <td>{{$r->member->user->name}}</td>
                <td class="center">
                    <a href="#"><i class="fas fa-trash-alt" ></i> Delete</a> |
                    <a href="#"><i class="fas fa-edit"></i> Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
