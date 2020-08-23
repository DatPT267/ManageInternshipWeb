@extends('admin.layout.index')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách nhóm đợt thực tập</h1>
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
                <th>Tên Nhóm</th>
                <th>Đề Tài</th>
                <th>Ghi nhớ</th>
                <th>Tên đợt thực tập</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listGroup as $gr)
            <tr class="odd gradeX" align="center">
                <td>{{$gr->name}}</td>
                <td>{{$gr->topic}}</td>
                <td>{{$gr->note}}</td>
                <td></td>
                <td class="center">
                    <form action="{{route('manageGroup.destroy', $gr->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-danger">
                        <a href="" class="btn btn-info">Edit</a>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
