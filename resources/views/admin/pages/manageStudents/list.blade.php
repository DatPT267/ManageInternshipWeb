@extends('admin.layout.index')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách sinh viên của đợt thực tập</h1>
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
                <th>Tên Sinh Viên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Ảnh cá nhân</th>
                <th>Địa Chỉ</th>
                <th>Hành động</th>
            </tr>
        </thead>
         <tbody>
            @foreach ($listStudent as $ls)
            <tr class="odd gradeX" align="center">
                <td>{{$ls->id}}</td>
                <td>{{$ls->name}} </td>
                <td>{{$ls->email}}</td>
                <td>{{$ls->phone}}</td>
                <td>  <img width="100px" src="image/user/{{$ls->image}}" ></td>
                <td>{{$ls->address}}</td>
                <td class="center">
                    <form action="" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-danger">
                        <a href="{{route('editUser', $ls->id)}}" class="btn btn-info">Edit</a>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody> 
    </table>
@endsection
