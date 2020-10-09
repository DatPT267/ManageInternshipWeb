@extends('user.layout.index')
@section('content')
    {{-- <h1 style="text-align: center">infomation User</h1> --}}
<div class="container">
    <div class="row m-5">
        <h1 style="text-align: center; margin: auto;">Cập nhật thông tin sinh viên</h1>
    </div>
    <div class="row">
        {{-- @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{$error}}
                    <br>
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
        @endif --}}
    </div>
    <div class="row">
        <div class="col">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">Thông tin sinh viên</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu1">Đổi mật khẩu</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                    <div id="home" class="container tab-pane active"><br>
                        <form action="{{route('user.update', $user->id)}}" method="POST" id="form-submit-profile" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-4">
                                    <h3 class="text-center">
                                        {{$user->name}}
                                    </h3>
                                    <div class="text-center">
                                        @if ($user->image == "")
                                            <img src="{{ asset('image/user/image-default.png') }}" name="aboutme" width="300" height="200" class="avatar img-circle img-thumbnail" alt="avatar">
                                        @else
                                            <img src="{{ asset("image/user/$user->image") }}" name="aboutme" width="300" height="200" class="avatar img-circle img-thumbnail" alt="avatar">
                                        @endif
                                        <h6>Upload a different photo...</h6>
                                        <input type="file" class="text-center center-block file-upload" name="image" id="image">

                                    </div>
                                </div>
                                <div class="col-sm-8" >
                                    <div class="form-group">
                                        <label for="account">Tên đăng nhập</label>
                                        <input type="email" id="account" disabled class="form-control" name="account" value="{{$user->account}}">

                                    </div>
                                    <div class="form-group">
                                        <label for="email">Tên </label>
                                        <input type="text" id="name" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}"" name="name" value="{{old('name', $user->name)}}">
                                        <div class="invalid-feedback">
                                            {{$errors->first('name')}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email </label>
                                        <input type="text" id="email" class="form-control {{$errors->first('email') ? 'is-invalid' : ''}}" name="email" value="{{old('email', $user->email)}}">
                                            <div class="invalid-feedback">
                                                {{$errors->first('email')}}
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="text" id="phone" class="form-control {{$errors->first('phone') ? 'is-invalid' : ''}}" name="phone" value="{{old('phone', $user->phone)}}">
                                        <div class="invalid-feedback">
                                            {{$errors->first('phone')}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Địa chỉ</label>
                                        <input type="text" id="address" class="form-control {{$errors->first('address') ? 'is-invalid' : ''}}" name="address" value="{{old('address', $user->address)}}">
                                        <div class="invalid-feedback">
                                            {{$errors->first('address')}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Đợt thực tập </label>
                                        <input type="text" class="form-control" disabled value="{{$user->internshipClass->name}}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                    {{-- <input type="reset" class="btn btn-secondary" value="Reset" > --}}
                                    <a href="{{url()->current()}}" class="btn btn-secondary">Làm mới</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="menu1" class="container tab-pane fade"><br>
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
                                <input type="password" name="password" class="form-control" />
                                <i class="" aria-hidden="true"></i>
                            </div>
                            <div class="form-group">
                                <div class="clearfix">
                                    <label class="control-label pull-left">Mật khẩu mới</label>
                                    <div class="pull-right"></div>
                                </div>
                                <input type="password" name="password1" class="form-control" />
                                <i class="" aria-hidden="true"></i>
                            </div>
                            <div class="form-group">
                                <div class="clearfix">
                                    <label class="control-label pull-left">Nhập lại mật khẩu</label>
                                    <div class="pull-right"></div>
                                </div>
                                <input type="password" name="password2" class="form-control" />
                                <i class="" aria-hidden="true"></i>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" id="btn-send-forgot-pass" class="btn btn-success">Đổi mật khẩu</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
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


