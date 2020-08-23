@extends('admin.layout.index')
@section('content')
    <h1>Danh sách Review của nhóm <strong>{{$nameGroup}}</strong></h1>
    <table class="table table-striped table-bordered table-hover" id="list-review">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Tên task</th>
                <th>Tên group</th>
                <th>Nội dung</th>
                <th>Người đánh giá</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($review as $r)
            <tr class="odd gradeX" align="center">
                <td>{{$r->id}}</td>
                <td>{{$r->task->name}}</td>
                <td>{{$r->group->name}}</td>
                <td>{{$r->content}}</td>
                <td>{{$r->member->user->name}}</td>
                <td class="center">
                    {{-- <a href="#" class="btn btn-danger btn-circle">
                        <i class="fas fa-trash"></i>
                    </a> --}}
                    <a href="#" class="btn btn-info btn-circle" data-toggle="modal" data-target=".show-detail">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </td>
            </tr>
            <!-- Extra large modal -->
            <div class="modal fade show-detail" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <td>{{$r->content}}</td> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            </div>
            @endforeach
        </tbody>
    </table>

@endsection
@section('script')
    <script>
        $('#list-review').dataTable({
        });
    </script>
@endsection
