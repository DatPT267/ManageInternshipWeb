@extends('admin.layout.index')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách các đợt thực tập</h1>
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
                <th>ID</th>
                <th>Name</th>
                <th>Start day</th>
                <th>End day</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listClass as $lc)
            <tr class="odd gradeX" align="center">
                <td>{{$lc->id}}</td>
                <td>{{$lc->name}}</td>
                <td>{{$lc->start_day}}</td>
                <td>{{$lc->end_day}}</td>
                <td>{{$lc->note}}</td>
                <td class="center">
                    <form action="{{route('internshipClass.destroy', $lc->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Xóa" class="btn btn-danger">
                        <a href="{{route('internshipClass.edit', $lc->id)}}" class="btn btn-info">Cập Nhật</a>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
