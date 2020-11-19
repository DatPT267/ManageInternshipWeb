@extends('admin.layout.index')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách Task: {{ $group->name }}</h1>
</div>

<a href="{{ route('addTask', $group->id) }}" class="btn btn-primary mb-3">Thêm task</a>
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
<table class="table table-striped table-bordered table-hover"  id="list-internship">
    <thead>
        <tr align="center">
            <th>STT</th>
            <th>Tên task</th>
            <th>Ghi chú</th>
            <th>Trạng thái</th>
            <th>Hoạt động</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0; ?>
        @foreach ($listTask as $ta)
        <tr class="odd gradeX">
            <td>{{ ++$i }}</td>
            <td>{{$ta->name}}</td>
            <td>{{$ta->note}}</td>
            
                @if($ta->status==1)
                <td class="btn btn-info" >Todo </td>
              
                @endif
                @if($ta->status==2)
                <td  class="btn btn-secondary" >Doing </td>
                @endif
                @if($ta->status==3)
                <td  class="btn btn-primary" >Review </td>
                @endif
                @if($ta->status==4)
                <td class="btn btn-success">Done </td>
                @endif
                @if($ta->status==5)
                <td class="btn btn-warning">Pending </td>
                @endif
           
            <td class="center">
                <a href="{{ route('manageTask.edit', $ta->id)}}" class="btn btn-info">Cập Nhật</a>
                <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-url="{{route('deleteTask', $ta->id)}}"   data-target="#exampleModal">
                    Xóa
                </button>
               
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="pagination float-right">
    {!! $listTask->links()!!}
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
                'info': false,
                'bLengthChange': false,
                'paging': false,
            });
        })
        // $(document).ready(function (){
        //     $('#list-internship').dataTable({
        //         'info': false,
        //         'bLengthChange': false,
        //         'columns': [
        //             {'orderable': true},
        //             {'orderable': false},
        //             {'orderable': false},
        //             {'orderable': false},
        //             {'orderable': false},
        //         ]
        //     });

        //     $('.btn-delete').click(function (){
        //         var url = $(this).attr('data-url');
        //         $('#form-delete').attr('action', url);
        //     })
        // })
    </script>
@endsection
