@extends('user.layout.index')
@section('content')
    {{-- <h1 style="text-align: center">infomation User</h1> --}}
    <div style="margin: 20px 30%;">
        <h1 style="text-align: center; margin-bottom: 20px">Cập nhật thông tin sinh viên</h1>
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
            @csrf
            @method('PUT')
            <center>
                @if ($user->image == "")
                <img src="{{ asset('image/user/image-default.png') }}" name="aboutme" width="200" height="200" class="avatar img-circle">
                @else
                    <img src="{{ asset('image/user/{{$user->image}}') }}" name="aboutme" width="200" height="200" class="avatar img-circle">
                @endif
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
            <div class="form-group">
                <label for="account">Tên đăng nhập</label>
                <input type="email" id="account" disabled class="form-control" name="account" value="{{$user->account}}">
            </div>
            <div class="form-group">
                <label>Đổi mật khẩu</label>
            <a href="user/{{$user->id}}/edit/#changepassword" class="btn btn-primary">Đổi mật khẩu</a>
            </div>
            <div class="form-group">
                <label for="email">Email </label>
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

    <!-- Đôi mật khẩu-->
    <div class="remodal" data-remodal-id="changepassword" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc" data-remodal-options="closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
        <div class="register">
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
        <form id="form-forgot-pass" action="{{ route('changepassword', $user->id)}}" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <h3>Đổi mật khẩu</h3>
                <div class="form-group">
                    <div class="clearfix">
                        <label class="control-label pull-left">Mật khẩu cũ</label>
                        <div class="pull-right"></div>
                    </div>
                    <input type="password" name="password" class="form-control input-lg" />
                    <i class="" aria-hidden="true"></i>
                </div>
                <div class="form-group">
                    <div class="clearfix">
                        <label class="control-label pull-left">Mật khẩu mới</label>
                        <div class="pull-right"></div>
                    </div>
                    <input type="password" name="password1" class="form-control input-lg" />
                    <i class="" aria-hidden="true"></i>
                </div>
                <div class="form-group">
                    <div class="clearfix">
                        <label class="control-label pull-left">Nhập lại mật khẩu</label>
                        <div class="pull-right"></div>
                    </div>
                    <input type="password" name="password2" class="form-control input-lg" />
                    <i class="" aria-hidden="true"></i>
                </div>
                <div class="form-group text-center">
                    <ul class="ul over">
                        <li><button type="submit" id="btn-send-forgot-pass" class="btn btn-lg btn-block btn-green">Đổi mật khẩu</button></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
 <!-- end đôi mật khẩu-->




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


