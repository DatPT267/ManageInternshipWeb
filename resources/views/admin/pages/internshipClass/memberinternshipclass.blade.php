@extends('admin.layout.index')
@section('content')
    <!-- Page Heading -->
    <div class="container-fluid">
        <a href="{{ route('internshipClass.index') }}" class="btn btn-light btn-icon-split">
            <span class="icon text-gray-600">
            <i class="fas fa-arrow-left"></i>
            Trở về
            </span>
        </a>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center">Danh sách sinh viên đợt thực tập</h1>
                    <form action="{{ route('storeStudentsOfInternshipclass', $name_unsigned) }}" method="POST" enctype="">
                        @csrf
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
                                    <td>
                                        <input class="form-control" name="name_student[]" type="text">
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <a align="center" class="btn btn-success" id="addRow">Thêm hàng</a>
                        <div align="center"><button type="submit" id=""  class="btn btn-info">Thêm</button></div>
                    </form>
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
    <script>
        $(document).ready(function (){
            $('#addRow').click(function(){
                $('#example tbody').append("<tr class='odd gradeX' align='center'><td><input class='form-control' name='name_student[]' type='text'></td><td></td><td></td></tr>");
            })
        })
    </script>
@endsection
