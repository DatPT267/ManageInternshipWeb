@extends('user.layout.index')
@section('content')
   {{-- <h1 style="text-align: center">infomation User</h1> --}}
   <div style="margin: 20px 30%;">
    <h1 style="text-align: center; margin-bottom: 20px">Thông tin sinh viên</h1>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{$error}}
            @endforeach
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    @if (session('fail'))
        <div class="alert alert-danger">
            {{session('fail')}}
        </div>
    @endif
    <div class="row">
        <div class="col-sm-6">
            <div class="row mgbt-xs-0">
                <img src="" alt="">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row mgbt-xs-0">
                <label class="col-xs-5 control-label">Tên:</label>
                <div class="col-xs-7 controls">Nguyễn Chế Thanh Tân</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row mgbt-xs-0">
                <label class="col-xs-5 control-label">Email:</label>
                <div class="col-xs-7 controls">thanhtan@gmail.com</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row mgbt-xs-0">
                <label class="col-xs-5 control-label">Số điện thoại:</label>
                <div class="col-xs-7 controls">0123456798</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row mgbt-xs-0">
                <label class="col-xs-5 control-label">Địa chỉ:</label>
                <div class="col-xs-7 controls">503 trưng nữ vương hải châu đà nẵng</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row mgbt-xs-0">
                <label class="col-xs-5 control-label">vị trí:</label>
                <div class="col-xs-7 controls">Thành viên nhóm</div>
            </div>
        </div>

    </div>
</div>
@endsection
