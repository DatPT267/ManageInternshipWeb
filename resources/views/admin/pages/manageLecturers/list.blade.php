
@extends('admin.layout.index')
@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách giảng viên của đợt thực tập</h1>
    </div>
    <a href="{{ route('manageLecturer.create') }}" class="btn btn-primary">Thêm giảng viên</a>
    <form action="{{ route('manageLecturer.index')  }}" method="get" class="form-inline mt-3">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Tên giảng viên</span>
            </div>
            <input type="text" class="form-control" name="nameStudentSearch" value="{{ Request::get('nameStudentSearch') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Email</span>
            </div>
            <input type="text" class="form-control" name="emailSearch" value="{{ Request::get('emailSearch') }}">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
            <a href="{{ route('manageLecturer.index')  }}" class="btn btn-secondary"><i class="fas fa-sync-alt"></i></a>
        </div>
    </form>
    <table class="table table-striped table-bordered table-hover" id="list-lecturer">
        <thead>
            <tr align="center">
                <th>STT</th>
                <th>Ảnh cá nhân</th>
                <th>Tên Giảng Viên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Địa Chỉ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($listLecturers as $lecturer)
            <tr class="odd gradeX" align="center">
                <td>{{$i++}}</td>
                <td>
                    @if ($lecturer->image != "")
                        <img width="100px" src="{{ asset('image/user/'.$lecturer->image) }}" width="100px" height="100px">

                    @else
                        <img width="100px" src="{{ asset('image/user/avatar.jpg') }}" width="100px" height="100px">
                    @endif
                </td>
                <td>{{$lecturer->name}} </td>
                <td>{{$lecturer->email}}</td>
                <td>{{$lecturer->phone}}</td>

                <td>{{$lecturer->address}}</td>
                <td class="center">
                    <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-url="{{route('manageLecturer.destroy', $lecturer->id)}}" data-target="#exampleModal">
                        Xóa
                    </button>
                    <a href="{{route('manageLecturer.edit', $lecturer->id)}}" class="btn btn-info">Cập Nhật</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form id="form-delete" action="" method="post">
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
            // $('#list-lecturer').dataTable({
            //     'info': false,
            //     'bLengthChange': false,
            //     'searching': false,
            //     'paginate': false,
            //     'columns': [
            //         {'orderable': true},
            //         {'orderable': false},
            //         {'orderable': true},
            //         {'orderable': false},
            //         {'orderable': false},
            //         {'orderable': false},
            //         {'orderable': false},
            //     ]
            // });
            $('.btn-delete').click(function (){
                var url = $(this).attr('data-url');
                $('#form-delete').attr('action', url);
            })
        })
    </script>
@endsection
