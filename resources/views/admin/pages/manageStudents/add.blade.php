@extends('admin.layout.index')

@section('content')
<div class="container">
    <div class="row m-5">
        <h1 style="text-align: center; margin: auto;">Thêm sinh viên</h1>
    </div>
    <form action="{{ route('manageStudents.store') }}" method="POST" enctype="multipart/form-data" id="form-update-infomation-student">
    @csrf
    <div class="row">
            <div class="col-sm-4">
                <div class="text-center">
                    <img src="{{ asset('image/user/image-default.png') }}" name="aboutme" width="300" height="200" class="avatar img-circle img-thumbnail" alt="avatar">
                    <h6>Upload a different photo...</h6>
                    <input type="file" class="text-center center-block file-upload {{$errors->first('image') ? 'is-invalid' : ''}}" name="image" id="image" >
                    <div class="invalid-feedback">{{$errors->first('image')}}</div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="name">Tên sinh viên <strong style="font-style: italic; color: red">(*)</strong>:</label>
                    <input type="text" name="name" id="name" placeholder="Nhập tên sinh viên" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}" value="{{ old('name') }}">
                    <div class="invalid-feedback">
                        {{$errors->first('name')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email <strong style="font-style: italic; color: red">(*)</strong>:</label>
                    <input type="email" name="email" id="email" placeholder="Nhập email" class="form-control {{$errors->first('email') ? 'is-invalid' : ''}}" value="{{ old('email') }}">
                    <div class="invalid-feedback">
                        {{$errors->first('email')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Địa chỉ:</label>
                    <input type="text" name="address" id="address" placeholder="Nhập địa chỉ" class="form-control {{$errors->first('address') ? 'is-invalid' : ''}}" value="{{ old('address') }}">
                    <div class="invalid-feedback">
                        {{$errors->first('address')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone_number">Số điện thoại:</label>
                    <input type="text" name="phone_number" id="phone_number" placeholder="Nhập số điện thoại" maxLength="11" class="form-control {{$errors->first('phone_number') ? 'is-invalid' : ''}}" value="{{ old('phone_number') }}">
                    <div class="invalid-feedback">
                        {{$errors->first('phone_number')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="district_choice">Đợt Thực Tập <strong style="font-style: italic; color: red">(*)</strong></label>
                    <select class="form-control custom-select {{$errors->first('namedotthuctap') ? 'is-invalid' : ''}}" id="district_choice" name="namedotthuctap">
                        <option value="" selected>Chọn đợt thực tập</option>
                        @foreach($classes as $class)
                            <option value="{{$class->id}}">{{$class->name}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">{{$errors->first('namedotthuctap')}}</div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Thêm sinh viên</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
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
                        email: true,
                    },
                    'phone_number': {
                        numberphone: true,
                        maxlength: 11,
                        minlength: 10,
                    },
                    'namedotthuctap': {
                        required: true
                    }
                },
                messages: {
                    'image': {
                        extension: "Bạn chỉ chọn được file có đuôi jpg, png, jpeg!",
                        // filesize: "Ảnh có kích thước tối đa là 10MB"
                    },
                    'name': {
                        required: "Bạn chưa nhập tên sinh viên"
                    },
                    'email': {
                        required: "Bạn chưa nhập email",
                        email: 'Bạn nhập sai định dạng email'
                    },
                    'phone_number': {
                        maxlength: 'Số điện thoại phải có độ dài là 10 hoặc 11 số',
                        minlength: 'Số điện thoại phải có độ dài là 10 hoặc 11 số',
                    },
                    'namedotthuctap': {
                        required: "Bạn chưa chọn đợt thực tập"
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
