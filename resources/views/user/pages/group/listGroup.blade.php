@extends('user.layout.index')
@section('content')
<div style="margin: 20px 20%;">
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
                    <td>{{$i}}</td>
                    <td>{{$item->group->name}}</td>
                    <td>
                        @if ($item->group->status == 0)
                            Không hoạt động
                        @else
                            Đang hoạt động
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
@endsection
