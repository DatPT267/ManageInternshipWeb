@extends('admin.layout.index')
@section('content')
<h1 style="color: #000;">Thêm Sinh Viên</h1>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7" style="padding-bottom:120px">
                @if(count($errors)>0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err)
                        {{$err}} <br>
                    @endforeach
                </div>
                 @endif
                @if(session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}
                    </div>
                @endif
            <form action="{{ route('addstudent') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label style="color: #000;">Tên Sinh Viên</label>
                        <input class="form-control" name="name" placeholder="Nhập Tên SInh Viên" />
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Email</label>
                        <input class="form-control" name="email" placeholder="Nhập Email" />
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">SĐT</label>
                        <input class="form-control" name="phone" placeholder="Nhập SĐT" />
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Ảnh cá nhân</label>
                         <img src="" alt="" width="300px" height="300px">
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Địa chỉ</label>
                        <input class="form-control" name="address" placeholder="Nhập địa chỉ" />
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Lớp Thực Tập</label>
                        <select class="form-control" id="district_choice" name="namedotthuctap">
                            @foreach($class as $tr)
                            <option value="{{$tr->id}}">{{$tr->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <button  style=" color: #fff;
                        background-color: #6499ff;
                        font-weight: 700;
                        padding: 10px 30px;
                        font-size: 16px;
                        border: none;
                        width: 100%;">Thêm Sinh Viên</button>
                    </div>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection