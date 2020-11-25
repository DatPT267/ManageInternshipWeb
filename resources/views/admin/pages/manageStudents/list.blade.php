@extends('admin.layout.index')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1>Danh sách sinh viên</h1>
    </div>
    <a href="{{ route('manageStudents.create') }}" class="btn btn-primary">Thêm sinh viên</a>
    <form action="{{ route('manageStudents.index')  }}" method="get" class="form-inline mt-3">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Tên sinh viên</span>
            </div>
            <input type="text" class="form-control" name="nameStudentSearch" value="{{ Request::get('nameStudentSearch') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Email</span>
            </div>
            <input type="text" class="form-control" name="emailSearch" value="{{ Request::get('emailSearch') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Tên đợt</span>
            </div>
            <input type="text" class="form-control" name="nameInternshipclassSearch" value="{{ Request::get('nameInternshipclassSearch') }}">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
            <a href="{{ route('manageStudents.index')  }}" class="btn btn-secondary"><i class="fas fa-sync-alt"></i></a>
        </div>
    </form>
    <table class="table table-striped table-bordered table-hover" id="list-internship">
        <thead>
            <tr>
                <th>STT</th>
                <th>Ảnh cá nhân</th>
                <th>Tên Sinh Viên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Đợt Thực Tập</th>
                <th>Địa Chỉ</th>
                <th>Trạng thái</th>
                <th>Làm mới mật khẩu</th>
                <th>Hành động</th>
            </tr>
        </thead>
         <tbody>
            <input type="hidden" value=" {{ $i = 1}}">
            @foreach ($students as $student)
                <tr class="odd gradeX">
                    <td>{{$i++}}</td>
                    <td  align="center" >
                        @if ($student->image == null)
                            <img width="100px" src="{{ asset('image/user/avatar.jpg') }}"  height="100px" >
                        @else
                            <img width="100px" src="{{ asset('image/user') }}/{{$student->image}}" height="100px" >
                        @endif
                    </td>
                    <td>
                        {{$student->name}}
                    </td>
                    <td>
                        {{$student->email}}
                    </td>
                    <td>
                        {{$student->phone}}
                    </td>
                    <td>
                        {{$student->internshipClass->name}}
                    </td>
                    <td>
                        {{$student->address}}
                    </td>
                    <td>
                        <a class="btn btn-default btn-flat activateCourse-22 ">
                            @if ($student->status == 0)
                                <i class="fas fa-toggle-off active-status-student" style="font-size: 30px" data-status="{{ $student->status }}" data-id="{{ $student->id }}"></i>
                            @else
                                <i class="fas fa-toggle-on active-status-student" style="color: green; font-size: 30px" data-status="{{ $student->status }}" data-id="{{ $student->id }}"></i>
                            @endif
                        </a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-show-modal-change-password" data-toggle="modal" data-target=".modal-changePassword" data-url="{{ route('resetPasswordStudent', $student->id) }}">Làm mới mật khẩu</button>
                    </td>
                    <td class="center">
                        <div class="dropdown">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                Xem
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('view-history-check', [$student->id, \Carbon\Carbon::now()->month]) }}">Xem lịch sử thực tập</a>
                                <a class="dropdown-item" href="{{ route('view-schedule', [$student->id, \Carbon\Carbon::now()->month]) }}">Xem lịch đăng ký</a>
                            </div>
                        </div>
                        <a href="{{route('manageStudents.edit', $student->id)}}" class="btn btn-info">Cập nhật</a>
                        <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-url="{{ route('manageStudents.destroy', $student->id) }}" data-target="#exampleModal">
                            Xóa
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row float-right mr-5 mt-3">
        {{ $students->render() }}
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <h3>Bạn có muốn xóa?</h3>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                    <form id="form-delete" method="post" action="">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Xóa" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show-modal-change-status-student" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    Xác nhận thay đổi?
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3><strong>Bạn có muốn thay đổi trạng thái?</strong></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Không</button>
                    <button type="button" class="btn btn-danger btn-submit-status">Có</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade modal-changePassword" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thay đổi mật khẩu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2>Bạn muốn thay đổi mật khẩu?</h2>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-primary">Làm mới mật khẩu</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $.ajaxSetup({
                headers:
                { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            function changeStatus(id, status){
                $.ajax({
                    type: "PUT",
                    url: "{{ route('changeStatusStudent') }}",
                    data: {status: status, id: id},
                    dataType: "json",
                    success: function (res) {

                    }
                });
            }
            $('.active-status-student').click(function () {
                var status = $(this).attr('data-status');
                var id = $(this).attr('data-id');
                var parentButton = this;
                $('.show-modal-change-status-student').modal('show');

                if(status == 1){
                    $('.btn-submit-status').click(function (){
                        changeStatus(id, status);
                        $(parentButton).attr('class', 'fas fa-toggle-off');
                        $(parentButton).attr('data-status', 0);
                        $(parentButton).css('color', "");
                        $('.show-modal-change-status-student').modal('hide');
                    })
                } else{
                    $('.btn-submit-status').click(function (){
                        changeStatus(id, status);
                        $(parentButton).attr('class', 'fas fa-toggle-on');
                        $(parentButton).attr('data-status', 1);
                        $(parentButton).css('color', "green");
                        $('.show-modal-change-status-student').modal('hide');
                    })
                }
            });

            $('.btn-delete').click(function (){
                var url = $(this).attr('data-url');
                console.log(url);
                $('#form-delete').attr('action', url);
            })


            $('.btn-show-modal-change-password').click(function (){
                var url = $(this).attr('data-url');
                $('.modal-changePassword .modal-footer a').attr('href', url);
            })


        })
    </script>
@endsection
