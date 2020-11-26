@extends('admin.layout.index')
@section('style')
    <style>


    </style>
@endsection
@section('content')
    <h1>Danh sách đánh giá <strong>{{$name_group}}</strong></h1>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-create-review">Thêm review</button>
    @include('admin.pages.manageGroup.reviews.add-reviewOfGroup')
    <table class="table table-bordered table-hover table-striped" id="list-review">
        <thead>
            <tr>
                <th>STT</th>
                <th>Nội dung reivew</th>
                <th>Người viết reivew</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $index => $review)
                @if ($review->member->user->id == Auth::id())
                    <tr style="font-weight: 700; background-color: #ffb366">
                        <td>{{++$index}}</td>
                        <td>{{$review->content}}</td>
                        <td>{{$review->member->user->name}}</td>
                        <td>
                            <a href="{{route('list.feedback', $review->id)}}" class="btn btn-primary">Chi tiết</a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{++$index}}</td>
                        <td>{{$review->content}}</td>
                        <td>{{$review->member->user->name}}</td>
                        <td>
                            <a href="{{route('list.feedback', $review->id)}}" class="btn btn-primary">Chi tiết</a>
                        </td>
                    </tr>

                @endif
            @endforeach
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        $(document).ready(function (){
            $('#list-review').dataTable({
                'order': false,
                'bLengthChange': false,
                'info': false
            });



            $('.btn-detail').click(function (){
                var content = $(this).attr('data-content');
                var id = $(this).attr('data-id');
                var url = $(this).attr('data-url');
                $('span#content-review').html("Nội dung review: <strong>"+content+"</strong>");
                // console.log(id);
                // console.log(url);
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response) {
                        console.log(response.data);
                        var output = '';
                        if(response.data.length != 0){
                            for (let i = 0; i < response.data.length; i++) {
                                output += "<tr>"+
                                            "<td>"+response.data[i].index+"</td>"+
                                            "<td>"+response.data[i].name+"</td>"+
                                            "<td>"+response.data[i].content+"</td>"+
                                            "<td>"+response.data[i].time+"</td>"+
                                            "<td>"+
                                                "<a href='#' class='btn btn-secondary btn-list-feedback' data-toggle='modal' data-content='"+response.data[i].content+"' data-url='' data-target='.modal-list-feedback'>Danh sách phản hồi</a>"+
                                                "<a href='#' class='btn btn-info btn-feedback' >Phản hồi</a>"
                                            +"</td>"
                                        +"</tr>"
                            }
                        }else{
                            output = "<tr style='text-align: center'>"+
                                        "<th colspan='5'>Chưa ai trả lời</th>"
                                    +"</tr>";
                        }

                        $('#table-body').html(output);
                    }
                });
            })


        })
    </script>
@endsection
