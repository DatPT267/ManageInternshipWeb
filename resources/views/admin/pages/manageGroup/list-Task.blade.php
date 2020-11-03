@extends('admin.layout.index')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách bài tập: {{ $group->name }}</h1>
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
            <th>Tên bài tập</th>
            <th>Ghi nhớ</th>
            <th>Trạng thái</th>
            <th>Hoạt động</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0; ?>
        @foreach ($listTask as $ta)
        <tr class="odd gradeX" align="center">
            <td>{{ ++$i }}</td>
            <td>{{$ta->name}}</td>
            <td>{{$ta->note}}</td>
            <td>
                @if($ta->status==1)
                {{"Todo"}}
                @endif
                @if($ta->status==2)
                {{"Doing"}}
                @endif
                @if($ta->status==3)
                {{"Review"}}
                @endif
                @if($ta->status==4)
                {{"Done"}}
                @endif
                @if($ta->status==5)
                {{"Pending"}}
                @endif
            </td>
            <td class="center">
                <a href="" class="btn btn-info">Cập Nhật</a>
                <button type="button" class="btn btn-danger btn-delete" data-toggle="modal"   data-target="#exampleModal">
                    Xóa
                </button>
               
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('#list-internship').dataTable({
                'info': false,
                'bLengthChange': false,
                'columns': [
                    {'orderable': true},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                ]
            });

            $('.btn-delete').click(function (){
                var url = $(this).attr('data-url');
                $('#form-delete').attr('action', url);
            })
        })
    </script>
@endsection
