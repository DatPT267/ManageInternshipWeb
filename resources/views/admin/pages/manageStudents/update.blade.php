@extends('admin.layout.index')
@section('content')
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
            <form action="{{route('updatestudent', $user->id)}}" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <h2 style="text-align:center; font-weight: bold; color: #000;" >Cập nhật thông tin sinh viên</h2>
                    <div class="form-group">
                        <label style="color: #000;">Tên Sinh Viên</label>
                    <input class="form-control" name="name" placeholder="Nhập Tên Sinh Viên" value="{{$user->name}}"/>
                    </div>

                    <div class="form-group">
                        <label style="color: #000;">Email</label>
                        <input class="form-control" name="email"  placeholder="Email"  value="{{$user->email}}"/>
                    </div>
                    
                    <div class="form-group">
                        <label style="color: #000;">SĐT</label>
                        <input class="form-control" name="phone"  placeholder="SĐT"  value="{{$user->phone}}"/>
                    </div>

                    <div class="form-group">
                        <label style="color: #000;">Ảnh cá nhân</label>
                        <p><img src="image/user/{{$user->image}}" alt="" width="300px" height="300px"></p>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Địa Chỉ</label>
                        <input class="form-control" name="address"  placeholder="Nhập Địa Chỉ"  value="{{$user->address}}"/>
                    </div>
                    <div class="">
                        <button  style=" color: #fff;
                        background-color: #6499ff;
                        font-weight: 700;
                        padding: 10px 30px;
                        font-size: 16px;
                        border: none;
                        width: 100%;">Cập nhật</button>
                    </div>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>
@endsection