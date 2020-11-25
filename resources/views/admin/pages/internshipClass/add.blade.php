@extends('admin.layout.index')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
    <style>
        .is-invalid{
            font-size: 1rem !important;
            color: red !important;
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Thêm đợt thực tập</h2>
                    <form action="{{ route('internshipClass.store')}}" method="POST" id="intern-create_form" >
                        @csrf
                        <div class="form-group">
                            <label style="color: #000;">Tên Đợt Thực Tập <strong style="font-style: italic; color: red">*</strong></label>
                        <input class="form-control" name="name" placeholder="Nhập Tên Đợt Thực Tập" value="{{ old('name') }}"/>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="form-label" style="color: #000;">Ngày Bắt Đầu <strong style="font-style: italic; color: red">*</strong></span>
                                    <input class="form-control" name="start_day" id="start_day" type="date" value="{{ old('start_day') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="form-label" style="color: #000;">Ngày Kết Thúc Dự Kiến <strong style="font-style: italic; color: red">*</strong></span>
                                    <input  class="form-control" id="end_day" name="end_day"type="date" value="{{ old('end_day') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="color: #000;">Ghi Chú</label>
                            <textarea class="form-control" name="note" id="" cols="30" rows="3" placeholder="Nhập Ghi Chú">{{ old('note') }}</textarea>
                        </div>
                        <div class="">
                            <button  style=" color: #fff;
                            background-color: #6499ff;
                            font-weight: 700;
                            padding: 10px 30px;
                            font-size: 16px;
                            border: none;
                            width: 100%;">Thêm đợt thực tập</button>
                        </div>
                    <form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function (){

        $('.input-daterange input').each(function() {
            $(this).datepicker('clearDates');
        });

        jQuery.validator.addMethod("greaterThan",
            function(value, element, params) {

                if (!/Invalid|NaN/.test(new Date(value))) {
                    return new Date(value) > new Date($(params).val());
                }

                return isNaN(value) && isNaN($(params).val())
                    || (Number(value) > Number($(params).val()));
            },'Ngày kết thúc phải lớn hơn ngày bắt đầu.');

        $('#intern-create_form').validate({
                errorClass: "is-invalid",
                errorElement: "em",
                rules: {
                    'name':{
                        required: true,
                    },
                    'end_day': {
                        required: true,
                        greaterThan: '#start_day',
                    },
                    'start_day': {
                        required: true
                    }
                },
                messages: {
                    'name': {
                        required: "Bạn chưa nhập tên đợt thực tập"
                    },
                    'end_day': {
                        required: "Bạn chưa chọn ngày kết thúc đợt thực tập"
                    },
                    'start_day': {
                        required: "Bạn chưa chọn ngày bắt đầu đợt thực tập"
                    }
                }
            });
    })
</script>
@endsection
