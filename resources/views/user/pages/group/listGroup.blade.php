@extends('user.layout.index')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h1 style="text-align: center">Danh sách group từng vào</h1>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên nhóm</th>
                        <th>Trạng thái</th>
                        <th>Đề tài</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $i => $item)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{$item->group->name}}</td>
                            <td>
                                @if ($item->group->status == 0)
                                    <span class="badge badge-danger" style="padding: 10px">Không hoạt động</span>
                                @else
                                    <span class="badge badge-primary" style="padding: 10px">Đang hoạt động</span>
                                @endif
                            </td>
                            <td>{{$item->group->topic}}</td>
                            <td>
                                <a href="{{route('user.group', [Auth::id(), $item->group_id])}}" class="btn btn-info">Chi tiet</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
