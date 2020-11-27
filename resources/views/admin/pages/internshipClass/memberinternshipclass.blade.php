@extends('admin.layout.index')
@section('style')
    <style>
        .is-invalid{
            font-size: 1rem !important;
            color: red !important;
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="container-fluid">

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('internshipClass.index') }}" class="btn btn-light btn-icon-split">
                        <span class="icon text-gray-600">
                        <i class="fas fa-arrow-left"></i>
                        Trở về
                        </span>
                    </a>
                    <h1 class="text-center">Danh sách sinh viên đợt thực tập</h1>
                    <form action="{{ route('storeStudentsOfInternshipclass', $name_unsigned) }}" method="POST" id="form-post-list-students">
                        @csrf
                        <table class="table table-bordered" id="list-students-create">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><input class='form-control' id='name_student' name='name_student[]' type='text'></td>
                                    <td style='width:65px'><button class='btn btn-danger delete-row'><i class='fas fa-trash-alt'></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <label class="btn btn-success" id="addRow">Thêm hàng</label>
                        <div align="center"><button type="submit" id=""  class="btn btn-info">Thêm</button></div>
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
                        <form action="{{ route('classImport', $name_unsigned) }}" method="post" enctype="multipart/form-data" id="import-data">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="file" class="form-control"/>
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
                var index = parseInt($('tbody tr:last-child td:first-child').html());
                console.log(index);
                if(isNaN(index)){
                    index = 1;
                } else{
                    index++;
                }

                $('#list-students-create tbody').append("<tr><td>"+index+"</td><td><input class='form-control' id='name_student' name='name_student[]' type='text'></td><td style='width:65px'><button class='btn btn-danger delete-row'><i class='fas fa-trash-alt'></i></button></td></tr>");
            });

            $('#list-students-create').on('click', '.delete-row', function (){
                $(this).closest("tr").remove();
            });
            $('#import-data').validate({
                rules: {
                    'file': {
                        extension: "xlsx|xls|xlsm"
                    }
                },
                messages: {
                    'file': {
                        extension: "Vui lòng chỉ tải lên các định dạng tệp hợp lệ .xlsx, .xlsm, .xls."
                    }
                }
            });
        });
    </script>
@endsection
