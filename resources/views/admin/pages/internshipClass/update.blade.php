@extends('admin.layout.index')
@section('content')
<div id="page-wrapper">
    <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('internshipClass.update', $internshipClass->id) }}" method="POST" >
                        @csrf
                        @method('PUT')
                        <h2 style="text-align:center;" >Cập nhật đợt thực tập</h2>
                        @if(session('thongbao'))
                            <div class="alert alert-danger">
                                {{session('thongbao')}}
                            </div>
                        @endif
                        <div class="form-group">
                            <label >Tên Đợt Thực Tập</label>
                        <input class="form-control" name="name" placeholder="Nhập Tên Đợt Thực Tập" value="{{ old('name', $internshipClass->name) }}"/>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="form-label" >Ngày Bắt Đầu</span>
                                    <input class="form-control" name="start_day"type="date" readonly  value="{{ old('start_day',\Carbon\Carbon::parse($internshipClass->start_day)->format('Y-m-d')) }}" />
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <span class="form-label" >Ngày Kết Thúc Dự Kiến</span>
                                    <input class="form-control" name="end_day" type="date" value="{{ old('end_day',\Carbon\Carbon::parse($internshipClass->end_day)->format('Y-m-d')) }}"/>
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
    @foreach ($errors->all() as $error)
        toastr.warning("{{$error}}")
    @endforeach
</script>
@endsection
