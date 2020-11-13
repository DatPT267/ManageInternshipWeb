@extends('admin.layout.index')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7" style="padding-bottom:120px">
            <form action="{{ route('updateclass', $class->id) }}" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <h2 style="text-align:center; font-weight: bold; color: #000;" >Cập nhật đợt thực tập</h2>
                    @if(session('thongbao'))
                        <div class="alert alert-danger">
                            {{session('thongbao')}}
                        </div>
                    @endif
                    <div class="form-group">
                        <label style="color: #000;">Tên Đợt Thực Tập</label>
                    <input class="form-control" name="name" placeholder="Nhập Tên Đợt Thực Tập" value="{{ old('name', $class->name) }}"/>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label" style="color: #000;">Ngày Bắt Đầu</span>
                                <input class="form-control" name="start_day"type="date" readonly  value="{{ old('start_day',\Carbon\Carbon::parse($class->start_day)->format('Y-m-d')) }}" />
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <span class="form-label" style="color: #000;">Ngày Kết Thúc Dự Kiến</span>
                                <input class="form-control" name="end_day" type="date" value="{{ old('end_day',\Carbon\Carbon::parse($class->end_day)->format('Y-m-d')) }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Ghi Chú</label>
                        <textarea class="form-control" name="note" id="" cols="30" rows="3" placeholder="Nhập Ghi Chú">{{ old('note', $class->note) }}</textarea>

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
@section('script')
<script>
    @foreach ($errors->all() as $error)
        toastr.warning("{{$error}}")
    @endforeach
</script>
@endsection
