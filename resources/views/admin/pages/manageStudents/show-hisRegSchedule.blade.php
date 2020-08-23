@extends('admin.layout.index')
@section('style')
    <style>
        tr, td{
            font-size: 110%;
        }
    </style>
@endsection
@section('content')
    <h1>Lịch sử thực tập của sinh viên <strong>{{$name}}</strong></h1>
    <table class="table table-striped table-bordered table-hover" id="example">
        <thead>
            <tr align="center">
                <th>STT</th>
                <th>Tên task</th>
                <th>Thời gian check-in</th>
                <th>Thời gian check-out</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checks as $check)
                <tr class="odd gradeX" align="center">
                    <label id="note" style="visibility: hidden">{{$check->note}}</label>
                    <td>{{$index++}}</td>
                    <td>{{$check->task->name}}</td>
                    <td>
                        <span class="badge badge-info">
                            {{\Carbon\Carbon::parse($check->date_start)->isoFormat('D/M/Y')}}
                        </span>
                        @switch(\Carbon\Carbon::parse($check->date_start)->isoFormat('dddd'))
                            @case('Monday')
                            - <span class="badge badge-primary">Thứ 2</span> -
                            @break
                        @case('Tuesday')
                            - <span class="badge badge-primary">Thứ 3</span> -
                            @break
                        @case('Wednesday')
                            - <span class="badge badge-primary">Thứ 4</span> -
                            @break
                        @case('Thursday')
                            - <span class="badge badge-primary">Thứ 5</span> -
                            @break
                        @case('Friday')
                            - <span class="badge badge-primary">Thứ 6</span> -
                            @break
                        @default

                    @endswitch
                    <span class="badge badge-info">{{\Carbon\Carbon::parse($check->date_start)->toTimeString()}}</span>
                    </td>
                    <td>
                        @if ($check->date_end != null)
                            <span class="badge badge-info">
                                {{\Carbon\Carbon::parse($check->date_end)->isoFormat('D/M/Y')}}
                            </span>
                            @switch(\Carbon\Carbon::parse($check->date_end)->isoFormat('dddd'))
                                @case('Monday')
                                    - <span class="badge badge-danger">Thứ 2</span> -
                                    @break
                                @case('Tuesday')
                                    - <span class="badge badge-danger">Thứ 3</span> -
                                    @break
                                @case('Wednesday')
                                    - <span class="badge badge-danger">Thứ 4</span> -
                                    @break
                                @case('Thursday')
                                    - <span class="badge badge-danger">Thứ 5</span> -
                                    @break
                                @case('Friday')
                                    - <span class="badge badge-danger">Thứ 6</span> -
                                    @break
                                @default

                            @endswitch
                            <span class="badge badge-info">{{\Carbon\Carbon::parse($check->date_end)->toTimeString()}}</span>
                        @else
                            <span class="badge badge-danger">Chưa check-out</span>
                        @endif
                    </td>
                    <td class="center">
                        <a href="#" class="btn btn-info btn-circle" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Modal -->
    {{-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>Tên task</th>
                    <td>Thanh tân</td>
                </tr>
                <tr>
                    <th>Tên</th>
                    <td>Thanh tân</td>
                </tr>
                <tr>
                    <th>Tên</th>
                    <td>Thanh tân</td>
                </tr>
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div> --}}
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('#example').dataTable({
                'paging': false,
                'info': false,
                'sort': false
            });
        });
    </script>
@endsection
