@extends('admin.index')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
<table class="table table-striped table-bordered table-hover" id="example">
    <thead>
        <tr align="center">
            <th>ID</th>
            <th>Name</th>
            <th>Start day</th>
            <th>End day</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($danhsachdot as $dsdot)
        <tr class="odd gradeX" align="center">
            <td>{{$dsdot->id}}</td>
            <td>{{$dsdot->name}}</td>
            <td>{{$dsdot->start_day}}</td>
            <td>{{$dsdot->end_day}}</td>
            <td class="center">
                <form action="{{route('internshipClass.destroy', $dsdot->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete" class="btn btn-danger">
                    <a href="{{route('internshipClass.edit', $dsdot->id)}}" class="btn btn-primary">Edit</a>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
