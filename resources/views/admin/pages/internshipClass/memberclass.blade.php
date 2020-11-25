@extends('admin.layout.index')
@section('content')
    <!-- Page Heading -->
    <div class="container-fluid">

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('internshipClass.index') }}" class="btn btn-light btn-icon-split">
                        <span class="icon text-gray-600">
                        <i class="fas fa-arrow-left"></i>
                        Trở về
                        </span>
                    </a>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Danh sách sinh viên đợt thực tập</h1>
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="example">
                        <thead>
                            <tr align="center">
                                <th>Tên</th>
                                <th>Tài khoản</th>
                                <th>Mật khẩu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usermember as $user)
                            <tr class="odd gradeX" align="center">
                                <td><input class="form-control" name="name" value="{{ $user->name }}" type="text" readonly></td>
                                <td>{{$user->account}}</td>
                                <td>123456</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
