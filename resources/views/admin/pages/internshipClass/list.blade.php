@extends('admin.layout.index')
@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">Danh sách các đợt thực tập</h1>
    <a href="{{ route('internshipClass.create') }}" class="btn btn-primary mb-3">Thêm đợt thực tập</a>
    <table class="table table-striped table-bordered table-hover" id="list-internship">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên đợt</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Ghi chú</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($listClass as $lc)
            <tr class="odd gradeX">
                <td>{{++$i}}</td>
                <td>{{$lc->name}}</td>
                <td>{{\Carbon\Carbon::parse($lc->start_day)->format('d-m-Y')}}</td>
                <td>{{\Carbon\Carbon::parse($lc->end_day)->format('d-m-Y')}}</td>
                <td>{{$lc->note}}</td>
                <td class="center">
                    <a href="{{route('internshipClass.show', $lc->id)}}" class="btn btn-warning">Danh Sách Sinh Viên</a>
                    <a href="{{route('internshipClass.edit', $lc->id)}}" class="btn btn-info">Cập Nhật</a>
                    <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-url="{{route('internshipClass.destroy', $lc->id)}}" data-target="#exampleModal">
                        Xóa
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination float-right">
        {!! $listClass->links()!!}
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
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('#list-internship').dataTable({
                'info': false,
                'bLengthChange': false,
                'paging': false,
            });

            $('.btn-delete').click(function (){
                var url = $(this).attr('data-url');
                $('#form-delete').attr('action', url);
            })

            // $('.pagination a').click(function (e) {
            //     e.preventDefault();
            //     var page = $(this).attr('href').split('page=')[1];
            //     fetch_data(page);
            // });

            // function fetch_data(page){
            //     var url = '{{ route("fetchDataPagination", ':page') }}';
            //     url = url.replace(':page', page);

            //     $('#list-internship').dataTable({
            //         'destroy': true,
            //         'info': false,
            //         'bLengthChange': false,
            //         'paging': false,
            //         "processing": true,
            //         "serverSide": true,
            //         'serverMethod': 'get',
            //         "ajax": {
            //             url: url
            //         },
            //         'columns': [
            //             {'orderable': false},
            //             { data: 'name', 'orderable': true},
            //             { data: 'start_day', 'orderable': false},
            //             { data: 'end_day', 'orderable': false},
            //             { data: 'note', 'orderable': false},
            //             {'orderable': false},
            //         ],

            //     });
            // }
        })
    </script>
@endsection
