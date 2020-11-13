@extends('admin.layout.index')
@section('content')
<div class="container-fluid">
    <h1>Danh sách thành viên của <strong>{{$sinhvien->name}}</strong></h1>
    @if (session('success'))
        <div class="alert alert-danger">
            {!! session('success') !!}
        </div>
    @endif
    
    <table class="table table-striped table-bordered table-hover" id="list-member">
        <thead>
            <tr >
                <th>STT</th>
                <th>Tên</th>
                <th>Ảnh hiển thị</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; ?>
            @foreach ($show as $sv)
            <tr class="odd gradeX" >
                <td>{{$index++}}</td>
                <td>{{$sv->name}}</td>
                <td>
                @if($sv->image == null)
                    <img src="{{asset('image/user/avatar.jpg')}}" width="100px" height="100px">
                @else
                    <img src="{{asset('image/user')}}/{{$sv->image}}" width="100px" height="100px">
                @endif
                </td>
                <td>{{$sv->email}}</td>
                <td>{{$sv->address}}</td>
                <td>{{$sv->phone}}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
    
</div>
@endsection