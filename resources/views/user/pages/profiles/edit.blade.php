@extends('user.layout.index')
@section('content')
    {{-- <h1 style="text-align: center">infomation User</h1> --}}
    <div class="row m-5">
        <h1 style="text-align: center; margin: auto;">Cập nhật thông tin sinh viên</h1>
    </div>
    <div class="row">
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
                    <div id="home" class="container-fluid tab-pane active"><br>
                        <form action="{{route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3 class="text-center">
                                        {{$user->name}}
                                    </h3>
                                    <div class="text-center">
                                        @if ($user->image == "")
                                            <img src="{{ asset('image/user/image-default.png') }}" name="aboutme" width="200" height="200" class="avatar img-circle img-thumbnail" alt="avatar">
                                        @else
                                            <img src="{{ asset("image/user/$user->image") }}" name="aboutme" width="200" height="200" class="avatar img-circle img-thumbnail" alt="avatar">
                                        @endif
                                        <h6>Upload a different photo...</h6>
                                        <input type="file" class="text-center center-block file-upload" name="image" id="image">

                                      </div>
                                </div>
                                <div class="col-sm-9" >
                                    <div class="form-group">
                                        <label for="account">Tên đăng nhập</label>
                                        <input type="email" id="account" disabled class="form-control" name="account" value="{{$user->account}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Tên </label>
                                        <input type="text" id="name" class="form-control" name="name" value="{{$user->name}}">
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


