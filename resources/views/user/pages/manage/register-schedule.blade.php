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
        @if (session('fail'))
            <div class="alert alert-warning">
                {{session('fail')}}
            </div>
        @endif
        <form action="{{route('reg.schedule', $user)}}" method="post">
            @csrf
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr align="center">
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
                                    <option value="1">Ca sáng</option>
                                    <option value="2">Ca chiều</option>
                                    <option value="0">Cả ngày</option>
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
                                    <option value="1">Ca sáng</option>
                                    <option value="2">Ca chiều</option>
                                    <option value="0">Cả ngày</option>
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
                                    <option value="1">Ca sáng</option>
                                    <option value="2">Ca chiều</option>
                                    <option value="0">Cả ngày</option>
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
                                    <option value="1">Ca sáng</option>
                                    <option value="2">Ca chiều</option>
                                    <option value="0">Cả ngày</option>
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
                                    <option value="1">Ca sáng</option>
                                    <option value="2">Ca chiều</option>
                                    <option value="0">Cả ngày</option>
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
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
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
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
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
                var output = "<ul class='list-group'>"+
                "<li class='list-group-item'>Thứ 2: "+check(thu2)+"</li>"+
                "<li class='list-group-item'>Thứ 3: "+check(thu3)+"</li>"+
                "<li class='list-group-item'>Thứ 4: "+check(thu4)+"</li>"+
                "<li class='list-group-item'>Thứ 5: "+check(thu5)+"</li>"+
                "<li class='list-group-item'>Thứ 6: "+check(thu6)+"</li>"+
                "<li class='list-group-item'><h2 style='color: orange'>Bạn chắc chắn muốn lưu lịch này?</h2></li>"
                +"</ul>";
                $('.modal-body').html(output);
            });
        })
    </script>
@endsection
