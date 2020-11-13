@extends('admin.layout.index')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách sinh viên đợt thực tập</h1>
    </div>
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
<form action="{{ route('member', $nameclass) }}" method="POST" enctype="">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <table class="table table-striped table-bordered table-hover" id="example">
            <thead>
                <tr align="center">
                    <th>Tên</th>
                    <th>Tài khoản</th>
                    <th>Mật khẩu</th>
                </tr>
            </thead>
            <tbody>
               
                <tr class="odd gradeX" align="center">
                    <td><input class="form-control" name="name_student[]" type="text"></td>
                    <td></td>
                    <td></td>

                </tr>

            </tbody>
        </table>
        <a align="center" class="btn btn-success" style="color: black" id="addRow">Thêm hàng</a>
        <div align="center"><button type="submit" id=""  class="btn btn-info">Thêm thành viên</button></div>
        </form>
      
@endsection
@section('script')
    <script>
        @foreach ($errors->all() as $error)
            toastr.warning("{{$error}}")
        @endforeach
    </script>
    <script>
        $(document).ready(function (){
            var html = $('#example tr:last').html();
            $('#addRow').click(function(){
                $('#example tbody').append("<tr class='odd gradeX' align='center'><td><input class='form-control' name='name_student[]' type='text'></td><td></td><td></td></tr>");
                console.log($('#example').html());
                // $('#example tbody').html(html);
            })
        })
    </script>
@endsection
