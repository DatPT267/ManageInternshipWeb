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
                <form action="{{ route('addTask', $id)}}" method="POST" enctype="">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label style="color: #000;">Tên task :</label>
                        <input class="form-control" name="name" placeholder="Nhập Tên Task" />
                    </div> 
                    <div class="form-group">
                        <label style="color: #000;">Trạng thái task</label>
                        <br>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="1" checked>ToDo
                            </label>
                          </div>
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="2">Doing
                            </label>
                          </div>
                          <div class="form-check-inline">
                            <label class="form-check-label"  for="radio3">
                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="3">Review
                            </label>
                          </div>
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio4">
                              <input type="radio" class="form-check-input" id="radio4" name="optradio" value="4">Done
                            </label>
                          </div>
                          <div class="form-check-inline">
                            <label class="form-check-label"  for="radio5">
                                <input type="radio" class="form-check-input" id="radio5" name="optradio" value="5">Pending
                            </label>
                          </div> 
                    </div>
                    
                    <div class="form-group">
                        <label style="color: #000;">Chú thích</label>
                        <input class="form-control" name="note" placeholder="Nhập Ghi Chú" />
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
