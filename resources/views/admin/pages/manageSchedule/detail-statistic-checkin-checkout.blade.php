@extends('admin.layout.index')
@section('style')
    <style>
        td{
            font-size: 20px;
            font-weight: 400
        }
    </style>
@endsection
@section('content')
    <h1>Thông tin chi tiết checkin-checkout</h1>
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Ngày thực tập</th>
                <th>Thời gian checkin</th>
                <th>Thời gian checkout</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checks as $index => $check)
                <tr>
                    <td>{{$index}}</td>
                    <td>
                        @switch(\Carbon\Carbon::parse($check->schedule->date)->isoFormat('dddd'))
                            @case('Monday')
                                <span class="badge badge-primary">Thứ 2</span>
                                @break
                            @case('Wednesday')
                                <span class="badge badge-primary">Thứ 3</span>
                                @break
                            @case('Tuesday')
                                <span class="badge badge-primary">Thứ 4</span>
                                @break
                            @case('Thursday')
                                <span class="badge badge-primary">Thứ 5</span>
                                @break
                            @case('Friday')
                                <span class="badge badge-primary">Thứ 6</span>
                                @break
                        @endswitch
                        <span class="badge badge-info">
                            {{\Carbon\Carbon::parse($check->schedule->date)->isoFormat('D-M-Y')}}

                        </span>
                    </td>
                    <td>
                        <span class="badge badge-primary">
                            {{\Carbon\Carbon::parse($check->date_start)->isoFormat('HH:mm:ss')}}
                        </span>
                    </td>
                    <td>
                        @if ($check->date_end !== null)
                            <span class="badge badge-warning">
                                {{\Carbon\Carbon::parse($check->date_end)->isoFormat('HH:mm:ss')}}
                            </span>
                        @else
                            <span class="badge badge-danger">Chưa check-out</span>
                        @endif
                    </td>
                    <td>
                        <button data-url="{{route('ajax.detail')}}" data-checkid="{{$check->id}}" class="btn btn-info btn-circle btn-show-detail">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                        </div>
                        <div class="modal-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="footer">

                        </div>
                    </div>
                </div>
            </div>
        </tbody>
    </table>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.btn-show-detail').click(function (){
                var url = $(this).attr('data-url');
                var check_id = $(this).attr('data-checkid');

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {id: check_id},
                    success: function (response) {
                    //    console.log(response);
                        var output = '';

                    }
                });
            })
        });
    </script>
@endsection
