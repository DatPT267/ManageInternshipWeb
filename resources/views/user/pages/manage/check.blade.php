@extends('user.layout.index')
@section('content')
    <div style="margin: 20px 30%;">
        <h1 style="text-align: center; margin-bottom: 20px">Check-in</h1>
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
        @endif
        @if ($check == 1)
            <div class="alert alert-warning">
                Hôm nay bạn đã checkin rồi !!!
            </div>
        @endif
        <form action="{{route('checkin.post', $id)}}" class="form-group" method="POST" >
            @csrf
            <div class="form-group" style="display: flex">
                <label style="flex: 1">Ngày thực tập</label>
                <input type="text" name="ngaythuctap" class="form-control"  value="{{\Carbon\Carbon::parse($schedule->date)->format('Y-m-d')}}" style="flex: 5" hidden>
                <input type="text" class="form-control"  value="{{\Carbon\Carbon::parse($schedule->date)->format('Y-m-d')}}" style="flex: 5" disabled>
            </div>
            <div class="form-group" style="display: flex">
                <label style="margin-right: 75px">Ca làm</label>
                @if ($schedule->session == 0)
                    <button disabled="disabled" class="btn btn-primary">Cả ngày</button>
                    {{-- <span class="badge badge-info" ><h3>Cả ngày</h3></span> --}}
                @elseif($schedule->session == 1)
                    <button disabled="disabled" class="btn btn-info">Ca sáng</button>
                @else
                    <button disabled="disabled" class="btn btn-warning">Ca chiều</button>
                @endif
            </div>
            @if ($check == 0)
                <div class="form-group" style="display: flex">
                    <label style="flex: 1">Task</label>
                    <select name="task" style="flex: 5">
                        <option value="" selected>lựa chọn:</option>
                        @foreach ($tasks as $task)
                            <option value="{{$task->task->id}}">{{$task->task->name}}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="form-group" style="display: flex">
                    <label style="flex: 1">Task</label>
                    <select name="task" style="flex: 5">
                        <option value="" selected>lựa chọn:</option>
                        @foreach ($tasks as $task)
                            @if ($task->task->id == $taskID)
                                <option value="{{$task->task->id}}" selected>{{$task->task->name}}</option>
                            @endif
                                <option value="{{$task->task->id}}">{{$task->task->name}}</option>
                        @endforeach
                    </select>
                </div>

            @endif
            @if ($check == 0)
                <button type="submit" class="btn btn-success">Check-in</button>
            @endif
        </form>
    </div>
@endsection
@section('script')
    <script>

    </script>
@endsection
