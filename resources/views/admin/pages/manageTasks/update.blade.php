@extends('admin.layout.index')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <h1 class="h3 mb-3 text-gray-800">Chi tiết Task: </h1>
        <div class="row">
            <div class="col-lg-6" style="padding-bottom:120px">
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
                <form action="{{ route('updateTask', $task->id) }}" method="POST" enctype="">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label style="color: #000;">Tên task :</label>
                        <input class="form-control" name="name" placeholder="Nhập Tên Task" value="{{ $task->name }}" />
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Trạng thái task</label>
                        <br>
                        <div class="form-check-inline">

                            <label class="form-check-label" for="radio1">
                                <input type="radio" class="form-check-input" id="radio1" name="optradio" value="1" @if (
                                    $task->status == 1)
                                checked
                                @endif
                                >ToDo
                            </label>


                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="radio2" name="optradio" value="2" @if (
                                    $task->status == 2)
                                checked
                                @endif
                                >Doing
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio3">
                                <input type="radio" class="form-check-input" id="radio3" name="optradio" value="3" @if (
                                    $task->status == 3)
                                checked
                                @endif
                                >Review
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio4">
                                <input type="radio" class="form-check-input" id="radio4" name="optradio" value="4" @if (
                                    $task->status == 4)
                                checked
                                @endif
                                >Done
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio5">
                                <input type="radio" class="form-check-input" id="radio5" name="optradio" value="5" @if (
                                    $task->status == 5)
                                checked
                                @endif
                                >Pending
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color: #000;">Ghi chú</label>
                        <textarea class="form-control" name="note" id="" cols="30" rows="3" placeholder="Nhập Ghi Chú" >{{ $task->note }}</textarea>
                    </div>
                    <div class="">
                        <button style=" color: #fff;
                        background-color: #6499ff;
                        font-weight: 700;
                        padding: 10px 30px;
                        font-size: 16px;
                        border: none;
                        width: 100%;">Cập nhật</button>
                    </div>



                    <form>
            </div>
            <div class="col-lg-6" style="padding-bottom:120px">
                <h5 class="h3 mb-3 text-gray-800">Thành viên </h5>
                <table class="table table-striped table-bordered table-hover" id="list-internship">
                    <thead>
                        <tr align="center">
                            <th>STT</th>
                            <th>Tên thành viên</th>
                            <th>Hành động</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; ?>
                        @foreach ($member as $mb)
                        <tr class="odd gradeX" align="center">
                            <td>{{++$i}}</td>
                            <td>{{ $mb->user->name }}</td>
                            <td>
                                <?php $tam=0; ?>
                                @foreach ($assign as $as)
                                @if ($as->member_id == $mb->id)

                                <input type="hidden" value="  {{++$tam}} ">
                                @break
                                @endif
                                @endforeach

                                @if ($tam == 0)
                                <button type="button" data-id="{{$mb->id}}" class="btn btn-primary btn_click_assign btn_assgin" data-url="{{ route('assign',[$task->id, $mb->id]) }}">Assign</button>
                                @else
                                <button type="button"  data-id="{{$mb->id}}" class="btn btn-success btn_click_assign btn_unassign" data-url="{{ route('assign',[$task->id, $mb->id]) }}">Unassign</button>
                                @endif





                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('script')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn_click_assign').click(function (){
            var url = $(this).attr('data-url');
            var id = $(this).attr('data-id');
            const btn = $(this);
            console.log(id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response){
                    console.log(response);
                    if(response == 0){
                        btn.html("Unassign");
                        btn.css('background-color', "#1cc88a" );
                        btn.css('border-color', "#1cc88a");
                    } 
                    if(response == 1){
                        btn.html("Assign");
                        btn.css('background-color', "#4e73df");
                        btn.css('border-color', "#4e73df");
                    }
                }
            });
        });
    });
</script>
@endsection
