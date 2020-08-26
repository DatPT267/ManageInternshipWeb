@extends('user.layout.index')
@section('content')
    <div style="margin: 20px 30%;">
        <h1 style="text-align: center; margin-bottom: 20px">Check-out</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif

        @if ($schedule === null)
            <div class="alert alert-warning">
                Hôm nay bạn không làm việc !!!
            </div>
        @else
            @if ($isCheckout == 1)
                <div class="alert alert-warning">
                    Hôm nay bạn đã check-out rồi !!!
                </div>
                    <div class="form-group" style="display: flex">
                        <label style="flex: 1"><strong> Thời gian checkout</strong></label>
                        <input type="text" name="ngaythuctap" class="form-control"  value="{{\Carbon\Carbon::now('asia/Ho_Chi_Minh')->format('Y-m-d H:i:s')}}" style="flex: 5" hidden>
                        <input type="text" class="form-control"  value="{{\Carbon\Carbon::now('asia/Ho_Chi_Minh')->format('d-m-Y H:i:s')}}" style="flex: 5" disabled>
                    </div>
                    <div class="form-group" style="display: flex">
                        <label style="margin-right: 75px"><strong>Ca làm</strong></label>
                        @if ($schedule->session == 0)
                            <span class="badge" style="background-color: #00FA9A; font-size: 15px">Cả ngày</span>
                        @elseif($schedule->session == 1)
                            <span class="badge" style="background-color: #87CEFA; font-size: 15px">Ca sáng</span>
                        @else
                            <span class="badge" style="background-color: #F4A460; font-size: 15px">Ca chiều</span>
                        @endif
                    </div>
                    <div class="form-group" style="display: flex">
                        <label style="flex: 1"><strong>Note</strong></label>
                        <label style="flex: 5">{{$note}}</label>
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
                                    <td>{{$key}}</td>
                                    <input type="text" value="{{$task->task->id}}" name="idTask[]" hidden >
                                    <td>{{$task->task->name}}</td>
                                    <td>
                                        <select name="status[{{$key}}]" disabled>
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
                            </tbody>
                        </table>
                    </div>

            @else
                <form action="{{route('checkout.post', Auth::id())}}" method="post">
                    @csrf
                    <div class="form-group" style="display: flex">
                        <label style="flex: 1">Thời gian check-out</label>
                        <input type="text" name="ngaythuctap" class="form-control"  value="{{\Carbon\Carbon::now('asia/Ho_Chi_Minh')->format('Y-m-d H:i:s')}}" style="flex: 5" hidden>
                        <input type="text" class="form-control"  value="{{\Carbon\Carbon::now('asia/Ho_Chi_Minh')->format('d-m-Y H:i:s')}}" style="flex: 5" disabled>
                    </div>
                    <div class="form-group" style="display: flex">
                        <label style="margin-right: 75px">Ca làm</label>
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
                                @foreach ($arrTask as $key => $task)
                                <tr>
                                    <td>{{$key}}</td>
                                    <input type="text" value="{{$task->task->id}}" name="idTask[]" hidden >
                                    <td>{{$task->task->name}}</td>
                                    <td>
                                        <select name="status[{{$key}}]">
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
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group" style="display: flex">
                        <label style="flex: 1">Note</label>
                        <textarea name="note" cols="30" rows="10" style="flex: 5" ></textarea>
                    </div>
                    @if ($isCheckout === 0)
                    <div class="form-group" style="display: flex">
                        <label style="flex: 1"></label>
                        <input type="submit" value="Lưu" class="btn btn-success" style="flex: 5">
                    </div>
                    @endif
                </form>

            @endif

        @endif
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('#listTask').DataTable({
                scrollY: 250,
                'info': false,
                'paging': false
            });
        })
    </script>
@endsection
