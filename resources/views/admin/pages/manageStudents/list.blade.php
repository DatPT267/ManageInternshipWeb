@extends('admin.layout.index')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1>Danh sách sinh viên</h1>
    </div>
    <a href="{{ route('manageStudents.create') }}" class="btn btn-primary">Thêm sinh viên</a>
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
                <th>Xem</th>
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
                        @if ($student->status == 0)
                            Không hoạt động
                        @else
                            Hoạt động
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Xem
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('view-history-check', [$student->id, \Carbon\Carbon::now()->month]) }}">Xem lịch sử thực tập</a>
                                <a class="dropdown-item" href="{{ route('view-schedule', [$student->id, \Carbon\Carbon::now()->month]) }}">Xem lịch đăng ký</a>
                            </div>
                        </div>
                    </td>
                    <td class="center">
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
                    <form id="form-delete" method="post" action="{{ route('manageStudents.destroy', $student->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Xóa" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('#list-internship').dataTable({
                "paging":   false,
                'info': false,
                'bLengthChange': false,
                'pageLength' : 5,
                'columns': [
                    {'orderable': true},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': true},
                    {'orderable': false},
                    {'orderable': false},
                ]
            });
            $('.btn-delete').click(function (){
                var url = $(this).attr('data-url');
                console.log(url);
                $('#form-delete').attr('action', url);
            })
        })
    </script>
@endsection
