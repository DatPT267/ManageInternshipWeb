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
<div id="page-wrapper">
    <a href="{{ route('internshipClass.index') }}" class="btn btn-light btn-icon-split">
        <span class="icon text-gray-600">
        <i class="fas fa-arrow-left"></i>
        Trở về
        </span>
    </a>
    <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2 style="text-align:center;" >Cập nhật đợt thực tập</h2>
                    <form action="{{ route('internshipClass.update', $internshipClass->id) }}" method="POST" id="form-update-internshipclass">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" >Tên Đợt Thực Tập <strong style="font-style: italic; color: red">*</strong></label>
                        <input class="form-control" id="name" name="name" placeholder="Nhập Tên Đợt Thực Tập" value="{{ old('name', $internshipClass->name) }}"/>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_day" >Ngày Bắt Đầu <strong style="font-style: italic; color: red">*</strong></label>
                                    <input  class="form-control" id="start_day" name="start_day" type="date" readonly  value="{{ old('start_day',\Carbon\Carbon::parse($internshipClass->start_day)->format('Y-m-d')) }}" />
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="end_day" >Ngày Kết Thúc Dự Kiến <strong style="font-style: italic; color: red">*</strong></label>
                                    <input class="form-control" id="end_day" name="end_day" type="date" value="{{ old('end_day',\Carbon\Carbon::parse($internshipClass->end_day)->format('Y-m-d')) }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label >Ghi Chú</label>
                            <textarea class="form-control" name="note" id="" cols="30" rows="3" placeholder="Nhập Ghi Chú">{{ old('note', $internshipClass->note) }}</textarea>

                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                        </div>
                    <form>
                </div>
            </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function (){

        jQuery.validator.addMethod("greaterThan",
            function(value, element, params) {

                if (!/Invalid|NaN/.test(new Date(value))) {
                    return new Date(value) > new Date($(params).val());
                }

                return isNaN(value) && isNaN($(params).val())
                    || (Number(value) > Number($(params).val()));
            },'Ngày kết thúc phải lớn hơn ngày bắt đầu.');

        $('#form-update-internshipclass').validate({
                errorClass: "is-invalid",
                errorElement: "em",
                rules: {
                    'end_day': {
                        greaterThan: '#start_day'
                    },
                    'name': {
                        required: true,
                        minlength: 4,

                    }
                },
                messages: {
                    'name': {
                        required: "Bạn chưa nhập tên đợt thực tập",
                        minlength: "Tên đợt thực tập tối thiểu trên 3 kí tự"
                    }
                }
            });
    })
</script>
@endsection
