@extends('admin.layout.index')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center">Thêm Nhóm</h1>
                    <form action="{{ route('manageGroup.store') }}" method="POST" id="create-group">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên Nhóm <strong style="color: red">*</strong> </label>
                            <input class="form-control" id="name" name="name" placeholder="Nhập Tên Nhóm" value="{{ old('name') }}"/>
                        </div>

                        <div class="form-group">
                            <label for="topic">Đề Tài Nhóm <strong style="color: red">*</strong></label>
                            <input class="form-control" id="topic" name="topic" placeholder="Nhập Đề Tài Nhóm" value="{{ old('topic') }}"/>
                        </div>
                        <div class="form-group">
                            <label for="note">Ghi Chú</label>
                            <textarea class="form-control" name="note" id="note" cols="30" rows="3">{{ old('note') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label >Tên Đợt Thực Tập <strong style="color: red">*</strong></label>
                            <select class="form-control" id="district_choice" name="internshipclass">
                                <option value="" >Chọn đợt thực tập</option>
                                @foreach($internshipClasses as $internshipClass)
                                    <option value="{{$internshipClass->id}}">{{$internshipClass->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái: </label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" checked>
                                <label class="form-check-label" for="inlineRadio1">Hoạt động</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0">
                                <label class="form-check-label" for="inlineRadio2">Không hoạt động</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Thêm</button>
                            <a href="{{ route('manageGroup.index') }}" class="btn btn-secondary">Trở về</a>
                        </div>
                    <form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            //validate field form
            $('#create-group').validate({
                rules: {
                    'name': {
                        required: true,
                    },
                    'topic': {
                        required: true,
                    },
                    'internshipclass': {
                        required: true
                    }
                },
                messages: {
                    'name': {
                        required: "Bạn chưa nhập tên nhóm"
                    },
                    'topic': {
                        required: "Bạn chưa nhập tên đề tài của nhóm"
                    },
                    'internshipclass': {
                        required: "Bạn chưa chọn đợt thực tập"
                    },
                }
            });
        });
    </script>
@endsection
