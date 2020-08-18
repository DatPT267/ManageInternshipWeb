@extends('admin.layout.index')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách các đợt thực tập</h1>
    </div>
<h1></h1>
<form action="" method="POST" enctype="">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                    <td><input class="form-control" name="" value="{{ $user->name }}" type=""></td>
                    <td>{{$user->account}}</td>
                    <td>123456789</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div align="center"><button type="submit" id=""  class="btn btn-info">Thêm thành viên</button></div>
    </form>
@endsection
