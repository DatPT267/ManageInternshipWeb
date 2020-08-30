@extends('admin.layout.index')
@section('content')
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
            <form action="{{route('updategroup', $group->id)}}" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <h2 style="text-align:center; font-weight: bold; color: #000;" >Cập nhật nhóm</h2>
                    <div class="form-group">
                        <label style="color: #000;">Tên Nhóm</label>
                        <input class="form-control" name="name" placeholder="Nhập Nhóm" value="{{$group->name}}"/>
                    </div>

                    <div class="form-group">
                        <label style="color: #000;">Đề tài</label>
                        <input class="form-control" name="topic" placeholder="Nhập Đề Tài"  value="{{$group->topic}}"/>
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Ghi chú</label>
                        <input class="form-control" name="note" placeholder="Nhập Ghi Chú"  value="{{$group->note}}"/>
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Tên Đợt Thực Tập</label>
                        <input class="form-control" name="" readonly  placeholder="Nhập Tên Đợt Thực Tập"  value="{{$group->internshipClass->name}}"/>
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Trạng Thái</label>
                        <select class="form-control" id="district_choice" name="status">
                            <option value="1"  
                            @if($group->status==1)
                            {{"selected"}}
                            @endif
                            >Đang hoạt động</option>
                            <option value="0" 
                            @if($group->status==0)
                            {{"selected"}}
                            @endif
                            >Không hoạt động</option>
                        </select>
                    </div>
                    <div class="">
                        <button  style=" color: #fff;
                        background-color: #6499ff;
                        font-weight: 700;
                        padding: 10px 30px;
                        font-size: 16px;
                        border: none;
                        width: 100%;">Cập nhật</button>
                    </div>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection