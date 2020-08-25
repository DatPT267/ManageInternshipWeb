@extends('admin.layout.index')
@section('content')
<h1 style="color: #000;">Thêm Nhóm</h1>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7" style="padding-bottom:120px">
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
            <form action="{{ route('addgroup') }}" method="POST" enctype="">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label style="color: #000;">Tên Nhóm</label>
                        <input class="form-control" name="" placeholder="Nhập Tên Đợt Thực Tập" />
                    </div>

                    <div class="form-group">
                        <label style="color: #000;">Đề Tài Nhóm</label>
                        <input class="form-control" name="" placeholder="Nhập Số Lượng Sinh Viên" />
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Ghi Chú</label>
                        <input class="form-control" name="" placeholder="Nhập Ghi Chú" />
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Tên Đợt Thực Tập</label>
                        
                    </div>
                    <div class="form-group">
                        <label>Trạng Thái</label>
                        <select class="form-control" id="district_choice" name="">
                            <option value="Hòa Vang" >Đang hoạt động</option>
                            <option value="Hoàng Sa" >Không hoạt động</option> 
                        </select>
                    </div>
                    <div class="">
                        <button  style=" color: #fff;
                        background-color: #6499ff;
                        font-weight: 700;
                        padding: 10px 30px;
                        font-size: 16px;
                        border: none;
                        width: 100%;">Thêm Nhóm</button>
                    </div>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection