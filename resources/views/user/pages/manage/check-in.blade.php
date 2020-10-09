@extends('user.layout.index')
@section('content')
    <div class="container">
        <h1 style="text-align: center; margin-bottom: 20px">Check-in</h1>
        <div class="card">
            <div class="card-body">


        @if (count($errors) > 0)
            <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{$error}}
            @endforeach
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @elseif ($isCheck == 1)
            <div class="alert alert-warning">
                Hôm nay bạn đã checkin rồi !!! <a href='{{route('checkout', Auth::id())}}' class="btn btn-danger">Check-out</a>
            </div>
        @endif
        @if ($schedule !== null)
            <form action="{{route('checkin.post', Auth::id())}}" class="form-group" method="POST" >
                @csrf
                @if ($isCheck == 0)
                    <div class="form-group row" >
                        <label class="col-sm-2 col-form-label"><strong>Thời gian checkin</strong></label>
                        <input type="hidden" name="ngaythuctap" class="form-control"  value="{{\Carbon\Carbon::now('asia/Ho_Chi_Minh')->format('Y-m-d')}}" >
                        <input type="text" class="form-control col-sm-10"  value="{{\Carbon\Carbon::now('asia/Ho_Chi_Minh')->format('d-m-Y H:i:s')}}"  disabled>
                    </div>
                @else
                    <div class="form-group row" >
                        <label class="col-sm-2 col-form-label"><strong>Thời gian check-in</strong></label>
                        <input type="text" class="form-control col-sm-10"  value="{{$date_start->date_start ?? ''}}" disabled>
                    </div>
                @endif
                <div class="form-group row" >
                    <label class="col-sm-2 col-form-label"><strong>Ca làm</strong></label>
                    @if ($schedule->session == 0)
                        <span class="badge" style="background-color: #00FA9A; font-size: 15px">Cả ngày</span>
                    @elseif($schedule->session == 1)
                        <span class="badge" style="background-color: #87CEFA; font-size: 15px">Ca sáng</span>
                    @else
                        <span class="badge" style="background-color: #F4A460; font-size: 15px">Ca chiều</span>
                    @endif
                </div>
                @if ($isCheck == 0)
                    <div class="form-group">
                        <table class="table table-bordered"  id="listTask">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên task</th>
                                    <th>Trạng thái task</th>
                                    <th>Chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tasks === 0)
                                    <tr>
                                        <th colspan="4" style="text-align: center">Bạn chưa vào nhóm hoặc chưa được giao task</th>
                                    </tr>
                                @else
                                    @foreach ($tasks as $key => $task)
                                            <tr>
                                                <td>{{$key}}</td>
                                                <td>{{$task->task->name}}</td>
                                                <td>
                                                    @if ($task->task->status == 0)
                                                        <span class="badge" style="background-color: #0000FF; font-size: 15px" >To-do</span>
                                                    @elseif($task->task->status == 1)
                                                        <span class="badge" style="background-color: #00BFFF; font-size: 15px" >Doing</span>
                                                    @elseif($task->task->status == 2)
                                                        <span class="badge" style="background-color: #FFA500; font-size: 15px" >Review</span>
                                                    @elseif($task->task->status == 3)
                                                        <span class="badge" style="background-color: #00FF7F; font-size: 15px" >Done</span>
                                                    @elseif($task->task->status == 4)
                                                        <span class="badge" style="background-color: #FF0000; font-size: 15px" >Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="chon-task[{{$key}}]" value="{{$task->task->id}}">
                                                </td>
                                            </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="form-group">
                        <table class="table table-bordered table-hover"  id="listTask">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên task</th>
                                    <th>Trạng thái task</th>
                                    <th>Chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tasks === 0)
                                    <tr>
                                        <th colspan="4" style="text-align: center">Bạn chưa vào nhóm hoặc chưa được giao task</th>
                                    </tr>
                                @else
                                    @foreach ($tasks as $key => $task)
                                        <tr>
                                            <td>{{$key}}</td>
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
                                                @elseif($task->task->status == 4)
                                                    <span class="badge" style="background-color: #5f5e5e; font-size: 15px">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($arrTask as $item)
                                                    @if ($task->task->id == $item->task_id)
                                                        <strong style="color: red; font-size: 20px;">x</strong>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endif
                @if ($isCheck == 0)
                    <button type="submit" class="btn btn-success">Check-in</button>
                @endif
            </form>
        @else
            <div class="alert alert-warning">
                Hôm nay bạn không làm việc !!!
            </div>
        @endif
        </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('#listTask').DataTable({
                'scrollY':        '200',
                'scrollCollapse': true,
                'deferRender':    true,
                'scroller':       true,
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
