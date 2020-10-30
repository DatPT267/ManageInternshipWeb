@extends('user.layout.index')
@section('content')
    <div class="container">
        <h1 style="text-align: center; margin-bottom: 20px">Check-out</h1>
        <div class="card">
            <div class="card-body">
                @if ($schedule === null)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Hôm nay bạn không làm việc !!!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @else
                    @if ($isCheckout == 1)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hôm nay bạn đã check-out rồi !!!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"><strong> Thời gian checkout</strong></label>
                            <input type="text" class="form-control col-sm-10"  value="{{\Carbon\Carbon::parse($checkout->date_end)->format('d-m-Y H:i:s')}}"  disabled>
                        </div>
                        <div class="form-group row" >
                            <label class="col-sm-2 col-form-label"><strong>Ca làm</strong></label>
                            @if ($schedule->session == 0)
                                <span class="badge" style="background-color: #00FA9A; font-size: 15px; ">Cả ngày</span>
                            @elseif($schedule->session == 1)
                                <span class="badge" style="background-color: #87CEFA; font-size: 15px">Ca sáng</span>
                            @else
                                <span class="badge" style="background-color: #F4A460; font-size: 15px">Ca chiều</span>
                            @endif
                        </div>
                        <div class="form-group row" >
                            <label class="col-sm-2 col-form-label"><strong>Note</strong></label>
                            <label class="col-sm-10 col-form-label">{{$checkout->note}}</label>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered table-hover"  id="listTask">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên task</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($arrTask as $key => $task)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <input type="text" value="{{$task->task->id}}" name="idTask[]" hidden >
                                        <td>{{$task->task->name}}</td>
                                        <td>
                                            @if ($task->task->status == 0)
                                                <span class="badge" style="background-color: #0000FF; font-size: 15px">To-do</span>
                                            @elseif($task->task->status == 1)
                                                <span class="badge" style="background-color: #00BFFF; font-size: 15px">Doing</span>
                                            @elseif($task->task->status == 2)
                                                <span class="badge" style="background-color: #FFA500; font-size: 15px">Review</span>
                                            @elseif($task->task->status == 3)
                                                <span class="badge" style="background-color: #00FF7F; font-size: 15px">Done</span>
                                            @else
                                                <span class="badge" style="background-color: #5f5e5e; font-size: 15px">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong style="color: red; font-size: 20px;">x</strong>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif($isCheckout == 2)
                        <form action="{{route('checkout.post', Auth::id())}}" method="post">
                            @csrf
                            <div class="form-group row" >
                                <label class="col-sm-2 col-form-label">Thời gian check-out</label>
                                <input type="hidden" name="ngaythuctap" class="form-control "  value="{{\Carbon\Carbon::now('asia/Ho_Chi_Minh')->format('Y-m-d H:i:s')}}"  hidden>
                                <input type="text" class="form-control col-sm-10"  value="{{\Carbon\Carbon::now('asia/Ho_Chi_Minh')->format('d-m-Y H:i:s')}}"  disabled>
                            </div>
                            <div class="form-group row" >
                                <label class="col-sm-2 col-form-label">Ca làm</label>
                                @if ($schedule->session == 0)
                                    <span class="badge" style="background-color: #00FA9A; font-size: 15px">Cả ngày</span>
                                @elseif($schedule->session == 1)
                                    <span class="badge" style="background-color: #87CEFA; font-size: 15px">Ca sáng</span>
                                @else
                                    <span class="badge" style="background-color: #F4A460; font-size: 15px">Ca chiều</span>
                                @endif
                            </div>
                            <div class="form-group" >
                                <table class="table table-bordered table-hover" id="listTask">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên task</th>
                                            <th>Trạng thái</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($arrTask !== null)

                                            @foreach ($arrTask as $key => $task)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <input type="text" value="{{$task->task->id}}" name="idTask[]" hidden >
                                                <td>{{$task->task->name}}</td>
                                                <td>
                                                    <select name="status[{{$key}}]" class="form-control">
                                                        @if ($task->task->status == 0)
                                                            <option value="0" selected>To-do</option>
                                                            <option value="1">Doing</option>
                                                            <option value="2">Review</option>
                                                            <option value="3">Done</option>
                                                            <option value="4">Pending</option>
                                                        @elseif($task->task->status == 1)
                                                            <option value="0">To-do</option>
                                                            <option value="1" selected>Doing</option>
                                                            <option value="2" >Review</option>
                                                            <option value="3">Done</option>
                                                            <option value="4">Pending</option>
                                                        @elseif($task->task->status == 2)
                                                            <option value="0">To-do</option>
                                                            <option value="1">Doing</option>
                                                            <option value="2" selected>Review</option>
                                                            <option value="3">Done</option>
                                                            <option value="4">Pending</option>
                                                        @elseif($task->task->status == 3)
                                                            <option value="0">To-do</option>
                                                            <option value="1">Doing</option>
                                                            <option value="2" >Review</option>
                                                            <option value="3" selected>Done</option>
                                                            <option value="4">Pending</option>
                                                        @else
                                                            <option value="0">To-do</option>
                                                            <option value="1">Doing</option>
                                                            <option value="2">Review</option>
                                                            <option value="3">Done</option>
                                                            <option value="4" selected>Pending</option>
                                                        @endif
                                                    </select>
                                                </td>
                                                <td>
                                                    <strong style="color: red; font-size: 20px;">x</strong>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group row" >
                                <label class="col-sm-2 col-form-label">Note</label>
                                <textarea class="form-control col-sm-10" name="note" cols="20" rows="10"  ></textarea>
                            </div>
                            <div class="form-group" >
                                <label ></label>
                                <input type="submit" value="Lưu" class="btn btn-success" >
                            </div>
                        </form>
                    @else
                    <div class="alert alert-warning">
                        Hôm nay bạn chưa checkin !!! <a href='{{ route('checkin', Auth::id()) }}' class="btn btn-info">Check-in</a>
                    </div>
                    @endif
                @endif
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
    <script>
        $(document).ready(function(){
            $('#listTask').DataTable({
                'info': false,
                'paging': false,
                "columns": [
                    null,
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                ]
            });
        })
    </script>
@endsection
