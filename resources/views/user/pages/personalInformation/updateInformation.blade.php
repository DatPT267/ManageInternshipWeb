@extends('user.layout.index')
@section('content')
    {{-- <h1 style="text-align: center">infomation User</h1> --}}
    <div style="margin: 20px 20%;">
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
        <form action="{{route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
            <center>
                <img src="storage/{{$user->image}}" name="aboutme" width="200" height="200" class="avatar img-circle">
                <div class="d-flex justify-content-center">
                    <div class="btn btn-mdb-color btn-rounded float-left">
                      <input type="file" class="form-control file-upload" name="image" id="image">
                    </div>
                </div>
                <h3 class="media-heading">
                    {{$user->name}}
                </h3>
            </center>
            <hr>
            @csrf
            {{-- <div class="form-group">
                <label for="image">Thay ảnh đại diện</label>
                <input type="file" class="form-control file-upload" name="image" id="image">
            </div> --}}
            <div class="form-group">
                <label for="account">Tên đăng nhập</label>
                <input type="email" id="account" disabled class="form-control" name="account" value="{{$user->account}}">
            </div>
            <div class="form-group">
                <label for="name">Họ tên</label>
                <input type="text" id="name" class="form-control" name="name" value="{{$user->name}}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" name="email" value="{{$user->email}}">
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" class="form-control" name="phone" value="{{$user->phone}}">
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" class="form-control" name="address" value="{{$user->address}}">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Đợt thực tập </label>
                <input type="text" class="form-control" disabled value="{{$user->internshipClass->name}}">
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.avatar').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".file-upload").on('change', function(){
                readURL(this);
            });
        });
    </script>
@endsection
