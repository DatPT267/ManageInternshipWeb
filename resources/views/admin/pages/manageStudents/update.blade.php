@extends('admin.layout.index')
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
<div class="container">
    <div class="row m-5">
        <h1 style="text-align: center; margin: auto;">Chỉnh sửa thông tin sinh viên</h1>
    </div>
    <form action="{{ route('manageStudents.update', $student->id) }}" method="POST" enctype="multipart/form-data" id="form-update-infomation-student">
    @method('PUT')
    @csrf
    <div class="row">
            <div class="col-sm-4">
                <div class="text-center">
                    @if ($student->image != null)
                        <img src="{{ asset('image/user/'.$student->image) }}" name="aboutme" width="300" height="200" class="avatar img-circle img-thumbnail" alt="avatar">
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
                    <label >Tên đăng nhập: <strong>{{ $student->account }}</strong></label>
                </div>
                <div class="form-group">
                    <label for="name">Tên sinh viên: <strong style="font-style: italic; color: red">(*)</strong></label>
                    <input type="text" name="name" id="name" placeholder="Nhập tên sinh viên" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}" value="{{ old('name', $student->name) }}">
                </div>
                <div class="form-group">
                    <label for="email">Email: <strong style="font-style: italic; color: red">(*)</strong></label>
                    <input type="text" name="email" id="email" placeholder="Nhập email" class="form-control {{$errors->first('email') ? 'is-invalid' : ''}}" value="{{ old('email', $student->email) }}">
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" name="address" id="address" placeholder="Nhập địa chỉ" class="form-control {{$errors->first('address') ? 'is-invalid' : ''}}" value="{{ old('address', $student->address) }}">
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" name="phone" id="phone" placeholder="Nhập số điện thoại" maxLength="11" class="form-control {{$errors->first('phone') ? 'is-invalid' : ''}}" value="{{ old('phone', $student->phone) }}">
                </div>
                <div class="form-group">
                    <label for="namedotthuctap">Đợt Thực Tập <strong style="font-style: italic; color: red">(*)</strong></label>
                    <select class="form-control custom-select {{$errors->first('namedotthuctap') ? 'is-invalid' : ''}}" id="namedotthuctap" name="namedotthuctap">
                        <option value="" selected disabled>Chọn đợt thực tập</option>
                        @foreach($classes as $class)
                            <option value="{{$class->id}}" {{ $class->id == $student->class_id ? "selected" : "" }}>{{$class->name}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">{{$errors->first('namedotthuctap')}}</div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>Trạng thái: </label>
                        <label><input type="checkbox" id="checkStatus" name="status"  {{ $student->status == 1 ? 'checked' : '' }}> <span id="textStatus">{{ $student->status == 1 ? 'Hoạt động' : 'Không hoạt động' }}</span></label>
                      </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Lưu</button>
                    <a href="{{ route('resetPasswordStudent', $student->id) }}" class="btn btn-primary float-right">Làm mới mật khẩu</a>
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
                if ( /^['a-zA-Za-zA-Z_ÀÁÂÃÈÉÊẾÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêếìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ \\s]+$/g.test(value)) {
                    return true;
                }else {
                    return false;
                };
            }, "Vui lòng nhập đúng định dạng tên");


            $('#form-update-infomation-student').validate({
                errorClass: "is-invalid",
                errorElement: "em",
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
                                    return "{{ $student->id }}"
                                }
                            }
                        },
                    },
                    'phone': {
                        // required: true,
                        numberphone: true,
                        maxlength: 11,
                        minlength: 10
                    },
                    'address': {
                        // required: true
                    },
                    'namedotthuctap': {
                        required: true
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
                        maxlength: 'Số điện thoại phải có độ dài là 10 hoặc 11 số',
                        minlength: 'Số điện thoại phải có độ dài là 10 hoặc 11 số',
                    },
                    'address': {
                    },
                    'namedotthuctap': {
                        required: "Bạn chưa chọn đợt thực tập"
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


            $('#checkStatus').click(function (){
                var text = $('#textStatus').text();

                if(text == "Không hoạt động"){
                    $('#textStatus').text("Hoạt động");
                } else{
                    $('#textStatus').text("Không hoạt động");
                }
            })


        });
    </script>
@endsection
