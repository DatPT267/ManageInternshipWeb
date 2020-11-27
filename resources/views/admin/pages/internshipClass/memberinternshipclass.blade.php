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
                    <div class="mb-3 d-flex">
                        <input type="file" id="uploadFile" name="uploadFile" class="form-control-file" style="width: 30%">
                        <button class="btn btn-secondary" id="btn-uploadFile">Upload tệp</button>
                    </div>
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

            // $('#btn-uploadFile').click(function (){
            //     var rdr = new FileReader();
            //     rdr.onload = function (e){
            //         var therows = e.target.result.split('\n');
            //         // console.log(therows);
            //         for (var row = 0; row < therows.length; row++) {
            //             var columns = therows[row].split(',');
            //             var newRow = "";

            //             var colCount = columns.length;
            //             if(colCount != 3){
            //                 newRow = `<tr>
            //                             <td colspan='3'>
            //                                 <strong>Không có thông tin sinh viên</strong>
            //                             </td>
            //                             <td style='width:65px'>
            //                                 <button class='btn btn-danger delete-row'>
            //                                     <i class='fas fa-trash-alt'>
            //                                     </i>
            //                                 </button>
            //                             </td>
            //                         </tr>`;
            //             } else{

            //                 newRow = `<tr>
            //                             <td>`+$.trim(columns[0])+`</td>
            //                             <td>
            //                                 <input id='name_student' class='form-control' name='name_student[]' type='text' value='`+$.trim(columns[1])+`' >
            //                             </td>
            //                             <td>
            //                                 <input id='email' class='form-control' name='email[]' type='email' value='`+$.trim(columns[2])+`' >
            //                             </td>
            //                             <td style='width:65px'>
            //                                 <button class='btn btn-danger delete-row'>
            //                                     <i class='fas fa-trash-alt'></i>
            //                                 </button>
            //                             </td>
            //                         </tr>`;
            //                 if($.trim(columns[1]) == "" && $.trim(columns[2]) == ""){
            //                     if($.isNumeric($.trim(columns[0]))){
            //                         newRow = "<tr><td>"+$.trim(columns[0])+"</td><td></td><td></td><td style='width:65px'><button class='btn btn-danger delete-row'><i class='fas fa-trash-alt'></i></button></td></tr>";
            //                     } else{
            //                         if($.trim(columns[0]).indexOf('@') < 0){
            //                             newRow = "<tr><td></td><td><input id='name_student' class='form-control' name='name_student[]' type='text' value='"+$.trim(columns[0])+"' ></td><td></td><td style='width:65px'><button class='btn btn-danger delete-row'><i class='fas fa-trash-alt'></i></button></td></tr>";
            //                         } else{
            //                             newRow = "<tr><td></td><td></td><td><input id='email' class='form-control' name='email[]' type='text' value='"+$.trim(columns[0])+"' ></td><td style='width:65px'><button class='btn btn-danger delete-row'><i class='fas fa-trash-alt'></i></button></td></tr>";
            //                         }
            //                     }
            //                 }
            //             }

            //             $('#list-students-create tbody').append(newRow);
            //         }

            //     }
            //     rdr.readAsText($('#uploadFile')[0].files[0]);
            // });

            // $('#form-post-list-students').validate({
            //     errorClass: "is-invalid",
            //     errorElement: "em",
            //     rules: {
            //         'name_student[]': {
            //             required: true
            //         },
            //         'email[]' : {
            //             required: true
            //         }
            //     },
            //     messages: {
            //         'name_student[]': {
            //             required: "Tên sinh viên bắt buộc"
            //         },
            //         'email[]' : {
            //             required: "Email sinh viên bắt buộc"
            //         }
            //     }
            // });
        });
    </script>
@endsection
