@extends(Auth::user()->position == 1 ? 'user.layout.index' : 'admin.layout.index')
@section('style')
    <style>
        .is-invalid{
            font-size: 1rem !important;
            color: red !important;
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
    {{-- <h1 style="text-align: center">infomation User</h1> --}}
<div class="container">
    <div class="row m-5">
        <h1 style="text-align: center; margin: auto;">Cập nhật thông tin sinh viên</h1>
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
                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{session('success')}}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="account">Tên đăng nhập</label>
                                        <input type="email" id="account" disabled class="form-control" name="account" value="{{$user->account}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Đợt thực tập </label>
                                        <input type="text" class="form-control" disabled value="{{$user->internshipClass->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Tên </label>
                                        <input type="text" id="name" class="form-control" name="name" value="{{old('name', $user->name)}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email </label>
                                        <input type="text" id="email" class="form-control" name="email" value="{{old('email', $user->email)}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="text" id="phone" class="form-control " name="phone" value="{{old('phone', $user->phone)}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Địa chỉ</label>
                                        <input type="text" id="address" class="form-control" name="address" value="{{old('address', $user->address)}}">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                    <a href="{{url()->current()}}" class="btn btn-secondary">Làm mới</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="menu1" class="container tab-pane fade"><br>
                        <h3>Đổi mật khẩu</h3>
                        <form id="form-forgot-pass" action="{{ route('changepassword', $user->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="oldPassword">Mật khẩu cũ</label>
                                <input type="password" name="oldPassword" id="oldPassword" class="form-control" placeholder="Nhập mật khẩu cũ">
                            </div>
                            <div class="form-group">
                                <label for="newPassword">Mật khẩu mới</label>
                                <input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="Nhập mật khẩu mới">
                            </div>
                            <div class="form-group">
                                <label for="confirm_newPassword">Xác nhận mật khẩu</label>
                                <input type="password" name="confirm_newPassword" id="confirm_newPassword" class="form-control" placeholder="Xác nhận mật khẩu">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Lưu</button>
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
            //validate field form
            jQuery.validator.addMethod("numberphone", function (value, element) {
                if(value == ""){
                    return true;
                }
                if ( /((09|03|07|08|05)+([0-9]{8})\b)/g.test(value)) {
                    return true;
                } else {
                    return false;
                };

            }, "Vui lòng nhập đúng định dạng điện thoại");

            jQuery.validator.addMethod("fullname", function (value, element) {
                if ( /^[a-zA-Za-zA-Z_ÀÁÂÃÈÉÊẾÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêếìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ \\s]+$/g.test(value)) {
                    return true;
                }else {
                    return false;
                };
            }, "Vui lòng nhập đúng định dạng tên");


            $('#form-submit-profile').validate({
                errorClass: "is-invalid",
                errorElement: "em",
                rules: {
                    'image': {
                        extension: "jpg|jpeg|png|gif",
                    },
                    'name': {
                        required: true,
                        fullname: true
                    },
                    'email': {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{ route('checkEmailAreadyExist') }}",
                            type: "GET",
                            contentTyoe: "application/json; charset=utf-8",
                            dataType: "json",
                            async: false,
                            data: {
                                email: function(){
                                    return $('#email').val();
                                },
                                id: function(){
                                    return "{{ $user->id }}"
                                }
                            }
                        }
                    },
                    'phone': {
                        maxlength: 11,
                        numberphone: true,
                    }
                },
                messages: {
                    'image': {
                        extension: "Bạn chỉ upload được file có đuôi jpg, png, jpeg!",
                    },
                    'name': {
                        required: "Bạn chưa nhập tên sinh viên"
                    },
                    'email': {
                        required: "Bạn chưa nhập email",
                        email: 'Bạn nhập sai định dạng email',
                        remote: "Email đã tồn tại"
                    },
                    'phone': {
                        maxlength: 'Số điện thoại không quá 11 số',
                    }
                },
            });

            $('#form-forgot-pass').validate({
                errorClass: "is-invalid",
                errorElement: "em",
                rules: {
                    'newPassword': {
                        required: true,
                    },
                    'oldPassword': {
                        required: true
                    },
                    'confirm_newPassword': {
                        required: true
                    }
                },
                messages: {
                    'oldPassword': {
                        required: "Bạn chưa nhập mật khẩu cũ",
                    },
                    'newPassword': {
                        required: "Bạn chưa nhập mật khẩu mới"
                    },
                    'confirm_newPassword': {
                        required: "Bạn chưa xác nhận mật khẩu mới"
                    },

                },
            });
            //show image
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


