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
                        <a align="center"class="btn btn-success" id="addRow" style="color: White">Thêm hàng</a>
                        <div style="text-align: center"><button type="submit" id=""  class="btn btn-info" >Thêm</button></div>
                    </form>
                    <div class="container" style="text-align: center">
                        <div class="container-fluid" style="margin: 10pt">
                            <div class="row">
                              <div class="col-sm-5">
                                <hr width="30%" style="margin-right: 0%">
                              </div>
                              <div class="col-sm-2">
                                <p style="color: black; size: 110%;" >Hoặc</p>
                              </div>
                              <div class="col-sm-5" >
                                <hr width="30%" style="margin-left: 0%">
                              </div>
                            </div>
                          </div>
                 
                
                      
                        <form action="{{ route('classImport', $name_unsigned) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="file" value="aâsas"/>
                                <button type="submit" class="btn btn-primary">Import Excel</button>
                            </div>
                       </form>
                    </div>
                   
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
