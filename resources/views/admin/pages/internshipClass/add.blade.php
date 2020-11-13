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
                    <div class="alert alert-danger">
                        {{session('thongbao')}}
                    </div>
                @endif
                <form action="{{ route('addClass')}}" method="POST" enctype="" id="intern-create_form" >
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label style="color: #000;">Tên Đợt Thực Tập</label>
                    <input class="form-control save_local" name="name" placeholder="Nhập Tên Đợt Thực Tập" value="{{ old('name') }}"/>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label" style="color: #000;">Ngày Bắt Đầu</span>
                                <input class="form-control save_local"name="start_day" type="date" value="{{ old('start_day') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <span class="form-label" style="color: #000;">Ngày Kết Thúc Dự Kiến</span>
                                <input class="form-control save_local" name="end_day"type="date" value="{{ old('end_day') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Ghi Chú</label>
                        {{-- <input class="form-control save_local" name="note" placeholder="Nhập Ghi Chú" value="{{ old('note') }}" /> --}}
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
