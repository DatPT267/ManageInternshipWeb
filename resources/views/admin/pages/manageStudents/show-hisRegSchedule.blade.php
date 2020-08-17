@extends('admin.layout.index')
@section('content')
    <h1>show history register Schedule</h1>
    <table class="table table-striped table-bordered table-hover" id="example">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Tên task</th>
                <th>Ghi chú</th>
                <th>Thời gian check-in</th>
                <th>Thời gian check-out</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd gradeX" align="center">
                <td>1</td>
                <td>name1</td>
                <td>status</td>
                <td>status</td>
                <td>status</td>
                <td class="center">
                    <a href="#"><i class="fas fa-trash-alt" ></i> Delete</a> |
                    <a href="#"><i class="fas fa-edit"></i> Edit</a>
                </td>
            </tr>
        </tbody>
    </table>

@endsection
