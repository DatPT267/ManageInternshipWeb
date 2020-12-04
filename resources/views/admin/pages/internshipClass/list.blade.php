@extends('admin.layout.index')
@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">Danh sách các đợt thực tập</h1>
    <a href="{{ route('internshipClass.create') }}" class="btn btn-primary mb-3">Thêm đợt thực tập</a>
        <form action="{{ route('internshipClass.index') }}" method="get" class="form-inline">
        <div class="input-group mb-3 mr-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Tên đợt</span>
            </div>
            <input type="text" class="form-control" name="nameSearch" value="{{ Request::get('nameSearch') }}">
        </div>
        <div class="input-group ml-5 mb-3 mr-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Từ ngày</span>
            </div>
            <input type="text" id="start_day" class="form-control date" name="dateStartSearch" value="{{ Request::get('dateStartSearch') }}">
        </div>
        <div class="input-group mb-3 mr-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Đến ngày</span>
            </div>
            <input type="text" data-date="" data-date-format="DD MM YYYY" id="end_date" class="form-control date" name="dateEndSearch" value="{{ Request::get('dateEndSearch') }}">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
            <a href="{{ route('internshipClass.index')  }}" class="btn btn-secondary"><i class="fas fa-sync-alt"></i></a>
        </div>
    </form>
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
            @if (count($listClass) > 0 )
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
            @else
                <tr>
                    <td colspan="6" align="center"><strong>Không có dữ liệu</strong></td>
                </tr>
            @endif
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
    <script>
        $(document).ready(function (){
            $('.date').datepicker({
                format: 'dd-mm-yyyy'
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
