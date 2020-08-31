@extends('user.layout.index')
@section('content')
    <div style="margin: 20px 20%;">
        <h1 style="text-align: center; margin-bottom: 20px">Đăng ký lịch thực tập của {{Auth::user()->name}}</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @elseif($message !== '')
            <div class="alert alert-warning">
                {{$message}}
            </div>
        @endif

        @if ($check == 1)
            <table class="table table-striped table-bordered table-hover" id="list-schedule">
                <thead>
                    <tr align="center">
                        <th>Ngày ({{$day_start}} -> {{$day_end}})</th>
                        <th>Ca Làm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr class="odd gradeX" align="center">
                            <td>
                                @switch(\Carbon\Carbon::parse($schedule->date)->isoFormat('dddd'))
                                    @case('Monday')
                                        Thứ 2 ({{\Carbon\Carbon::parse($schedule->date)->isoFormat('D-M-Y')}})
                                        @break
                                    @case('Tuesday')
                                        Thứ 3 ({{\Carbon\Carbon::parse($schedule->date)->isoFormat('D-M-Y')}})
                                        @break
                                    @case('Wednesday')
                                        Thứ 4 ({{\Carbon\Carbon::parse($schedule->date)->isoFormat('D-M-Y')}})
                                        @break
                                    @case('Thursday')
                                        Thứ 5 ({{\Carbon\Carbon::parse($schedule->date)->isoFormat('D-M-Y')}})
                                        @break
                                    @case('Friday')
                                        Thứ 6 ({{\Carbon\Carbon::parse($schedule->date)->isoFormat('D-M-Y')}})
                                        @break
                                    @default
                                @endswitch
                            </td>
                            <td>
                                @if ($schedule->session == 0)
                                    <p style="color: cadetblue"><b>Cả ngày</b></p>
                                @elseif ($schedule->session == 1)
                                    <p style="color: cornflowerblue"><b>Ca sáng</b></p>
                                @else
                                    <p style="color: orange"><b>Ca chiều</b></p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <form action="{{route('reg.schedule', $user)}}" method="post">
                @csrf
                <table class="table table-striped table-bordered table-hover" >
                    <thead>
                        <tr align="center">
                            <input type="hidden" name="week" value="{{$week}}">
                            <th>Ngày ({{$day_start}} -> {{$day_end}})</th>
                            <th>Ca Làm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd gradeX" align="center">
                            <td>Thứ 2</td>
                            <td>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Ca làm</label>
                                    </div>
                                    <select class="custom-select" name="thu2" id="thu2">
                                        <option selected value="null">Không làm</option>
                                        <option value="0">Cả ngày</option>
                                        <option value="1">Ca sáng</option>
                                        <option value="2">Ca chiều</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="odd gradeX" align="center">
                            <td>Thứ 3</td>
                            <td>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Ca làm</label>
                                    </div>
                                    <select class="custom-select" name="thu3" id="thu3">
                                        <option selected value="null">Không làm</option>
                                        <option value="0">Cả ngày</option>
                                        <option value="1">Ca sáng</option>
                                        <option value="2">Ca chiều</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="odd gradeX" align="center">
                            <td>Thứ 4</td>
                            <td>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Ca làm</label>
                                    </div>
                                    <select class="custom-select" name="thu4" id="thu4">
                                        <option selected value="null">Không làm</option>
                                        <option value="0">Cả ngày</option>
                                        <option value="1">Ca sáng</option>
                                        <option value="2">Ca chiều</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="odd gradeX" align="center">
                            <td>Thứ 5</td>
                            <td>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Ca làm</label>
                                    </div>
                                    <select class="custom-select" name="thu5" id="thu5">
                                        <option selected value="null">Không làm</option>
                                        <option value="0">Cả ngày</option>
                                        <option value="1">Ca sáng</option>
                                        <option value="2">Ca chiều</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="odd gradeX" align="center">
                            <td>Thứ 6</td>
                            <td>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Ca làm</label>
                                    </div>
                                    <select class="custom-select" name="thu6" id="thu6">
                                        <option selected value="null">Không làm</option>
                                        <option value="0">Cả ngày</option>
                                        <option value="1">Ca sáng</option>
                                        <option value="2">Ca chiều</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        @if ($check == 0)
                        <tr class="odd gradeX" align="center" >
                            <td colspan="3">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" id="confirm">
                                    Lưu
                                </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Bạn chắc chắn với điều này?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Không, thoát</button>
                                        <button type="submit" class="btn btn-primary btn-submit">Đúng, lưu lại</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </form>

        @endif
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('#list-schedule').dataTable({
                'info': false,
                'lengthChange': false,
                "bSort" : false
            });

            function check(thu){
                switch (thu) {
                    case '1':
                        return "Ca sáng";
                        break;
                    case '2':
                        return "Ca chiều";
                        break;
                    case '0':
                        return "Cả ngày";
                        break;
                    default:
                        return "Không làm";
                        break;
                }
            }
            $('#confirm').click(function(){
                var thu2 = $('#thu2 option:selected').val();
                var thu3 = $('#thu3 option:selected').val();
                var thu4 = $('#thu4 option:selected').val();
                var thu5 = $('#thu5 option:selected').val();
                var thu6 = $('#thu6 option:selected').val();
                console.log(thu2);
                if(thu2 == 'null' && thu3 == 'null' && thu4 == 'null' && thu5 == 'null' && thu6 == 'null'){
                    var output = "<div class='alert alert-warning'>1 tuần phải có ít nhất 1 ngày làm!</div>"+
                    "<ul class='list-group'>"+
                        "<li class='list-group-item'>Thứ 2: <strong>"+check(thu2)+"</strong></li>"+
                        "<li class='list-group-item'>Thứ 3: <strong>"+check(thu3)+"</strong></li>"+
                        "<li class='list-group-item'>Thứ 4: <strong>"+check(thu4)+"</strong></li>"+
                        "<li class='list-group-item'>Thứ 5: <strong>"+check(thu5)+"</strong></li>"+
                        "<li class='list-group-item'>Thứ 6: <strong>"+check(thu6)+"</strong></li>"
                    +"</ul>";
                    $('.modal-body').html(output);
                    $('.btn-submit').hide();
                    $('.btn-close').text('Thoát');
                }else{
                    var output = "<ul class='list-group'>"+
                    "<li class='list-group-item'>Thứ 2: <strong>"+check(thu2)+"</strong></li>"+
                    "<li class='list-group-item'>Thứ 3: <strong>"+check(thu3)+"</strong></li>"+
                    "<li class='list-group-item'>Thứ 4: <strong>"+check(thu4)+"</strong></li>"+
                    "<li class='list-group-item'>Thứ 5: <strong>"+check(thu5)+"</strong></li>"+
                    "<li class='list-group-item'>Thứ 6: <strong>"+check(thu6)+"</strong></li>"+
                    "<li class='list-group-item'><h2 style='color: orange'>Bạn chắc chắn muốn lưu lịch này?</h2></li>"
                    +"</ul>";
                    $('.btn-close').text('Không, thoát');
                    $('.btn-submit').show();
                    $('.modal-body').html(output);
                }
            });
        })
    </script>
@endsection
