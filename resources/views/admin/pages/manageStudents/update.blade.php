@extends('admin.layout.index')
@section('style')
    <style>
        .error{
            font-size: 1rem !important;
            color: red !important;
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row m-5">
        <h1 style="text-align: center; margin: auto;">Chỉnh sửa thông tin sinh viên</h1>
    </div>
    <form action="{{ route('manageStudents.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="form-update-infomation-student">
    @method('PUT')
    @csrf
    <div class="row">
            <div class="col-sm-4">
                <div class="text-center">
                    @if ($user->image != null)
                        <img src="{{ asset('image/user/'.$user->image) }}" name="aboutme" width="300" height="200" class="avatar img-circle img-thumbnail" alt="avatar">
                    @else
                        <img src="{{ asset('image/user/image-default.png') }}" name="aboutme" width="300" height="200" class="avatar img-circle img-thumbnail" alt="avatar">
                    @endif
                    <h6>Upload a different photo...</h6>
                    <input type="file" class="text-center center-block file-upload {{$errors->first('image') ? 'is-invalid' : ''}}" name="image" id="image" >
                </div>
            </div>
            <div class="col-sm-8">
                @if (session('thongbao'))
                    <div class="form-group">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('thongbao') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label >Tên đăng nhập: <strong>{{ $user->account }}</strong></label>
                </div>
                <div class="form-group">
                    <label>Đợt Thực Tập: <strong>{{ $user->internshipClass->name }}</strong> </label>
                </div>
                <div class="form-group">
                    <label for="name">Tên sinh viên: <strong style="font-style: italic; color: red">(*)</strong></label>
                    <input type="text" name="name" id="name" placeholder="Nhập tên sinh viên" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}" value="{{ old('name', $user->name) }}">
                </div>
                <div class="form-group">
                    <label for="email">Email: <strong style="font-style: italic; color: red">(*)</strong></label>
                    <input type="text" name="email" id="email" placeholder="Nhập email" class="form-control {{$errors->first('email') ? 'is-invalid' : ''}}" value="{{ old('email', $user->email) }}">
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" name="address" id="address" placeholder="Nhập địa chỉ" class="form-control {{$errors->first('address') ? 'is-invalid' : ''}}" value="{{ old('address', $user->address) }}">
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" name="phone" id="phone" placeholder="Nhập số điện thoại" maxLength="11" class="form-control {{$errors->first('phone') ? 'is-invalid' : ''}}" value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="form-group">
                    <label >Trạng thái:</label>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="status" class="custom-control-input" value="1" {{ $user->status == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customRadioInline1" >Hoạt động</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="status" class="custom-control-input" value="0" {{ $user->status == 0 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customRadioInline2">Không hoạt động</label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Lưu</button>
                    <a href="{{ route('resetPasswordStudent', $user->id) }}" class="btn btn-primary float-right">Làm mới mật khẩu</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        @foreach ($errors->all() as $error)
            toastr.warning("{{$error}}")
        @endforeach
    </script>
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
                if ( /^[a-zA-Za-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ \\s]+$/g.test(value)) {
                    return true;
                }else {
                    return false;
                };
            }, "Vui lòng nhập đúng định dạng tên");

            // jQuery.validator.setDefaults({
            //     debug: true,
            // });

            $('#form-update-infomation-student').validate({
                rules: {
                    'image': {
                        extension: "jpg|jpeg|png|gif",
                        // filesize : 10000,
                    },
                    'name': {
                        required: true,
                        fullname: true
                    },
                    'email': {
                        required: true,
                        email: true
                    },
                    'phone': {
                        // required: true,
                        numberphone: true,
                        maxlength: 11,
                        minlength: 10
                    },
                    'address': {
                        // required: true
                    }
                },
                messages: {
                    'image': {
                        extension: "Bạn chỉ upload được file có đuôi jpg, png, jpeg!",
                        // filesize: "Ảnh có kích thước tối đa là 10MB"
                    },
                    'name': {
                        required: "Bạn chưa nhập tên sinh viên"
                    },
                    'email': {
                        required: "Bạn chưa nhập email",
                        email: 'Bạn nhập sai định dạng email'
                    },
                    'phone': {
                        // required: "Bạn chưa nhập số điện thoại",
                        maxlength: 'Số điện thoại phải có độ dài là 10 hoặc 11 số',
                        minlength: 'Số điện thoại phải có độ dài là 10 hoặc 11 số',
                    },
                    'address': {
                        // required: "Bạn chưa nhập địa chỉ"
                    }
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
