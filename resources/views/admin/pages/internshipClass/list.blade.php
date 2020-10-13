@extends('admin.layout.index')
@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">Danh sách các đợt thực tập</h1>
    <a href="{{ route('internshipClass.create') }}" class="btn btn-primary mb-3">Thêm đợt thực tập</a>
    @if (session('success'))
        <div class="alert alert-success">
            <strong>{{session('success')}}</strong>
        </div>
    @endif
    @if (session('fail'))
        <div class="alert alert-danger">
            <strong>{{session('fail')}}</strong>
        </div>
    @endif
    <table class="table table-striped table-bordered table-hover" id="list-internship">
        <thead>
            <tr align="center">
                <th>STT</th>
                <th>Tên đợt</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Ghi chú</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($listClass as $lc)
            <tr class="odd gradeX" align="center">
                <td>{{++$i}}</td>
                <td>{{$lc->name}}</td>
                <td>{{$lc->start_day}}</td>
                <td>{{$lc->end_day}}</td>
                <td>{{$lc->note}}</td>
                <td class="center">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                        Xóa
                    </button>
                    <a href="{{route('internshipClass.edit', $lc->id)}}" class="btn btn-info">Cập Nhật</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
                    <form action="{{route('internshipClass.destroy', $lc->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Xóa" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('#list-internship').dataTable({
                'info': false,
                'blengthChange': false
            });
        })
    </script>
@endsection
