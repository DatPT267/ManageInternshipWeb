@extends('admin.layout.index')
@section('content')
    <h1>Danh sách feedback</h1>
    <span>Nội dung: <strong>{{$content_review}}</strong></span>
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
    <br>
    <br>
    <button class="btn btn-primary" data-target=".modal-create" data-toggle="modal">Thêm feedback</button>
    @include('admin.pages.manageGroup.feedbacks.add-feedback')
    <table class="table table-hover table-bordered table-striped" id="list-feedback">
        <thead>
            <tr>
                <th>STT</th>
                <th>Người feedback</th>
                <th>Nội dung feedback</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($feedbacks as $key => $feedback)
                @if ($feedback->user_id === Auth::id())
                    <tr style="font-weight: 700; background-color: #ffb366">
                        <td>{{$key}}</td>
                        <td>{{$feedback->user->name}}</td>
                        <td>{{$feedback->content}}</td>
                        <td>
                            <button class="btn btn-primary btn-show"
                            data-content="{{$feedback->content}}"
                            data-url="{{route('ajax-feedback', $feedback->id)}}"
                            data-id="{{Auth::id()}}"
                            data-idFeedback="{{$feedback->id}}"
                            data-toggle="modal"
                            data-target=".modal-detail">Detail</button>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$feedback->user->name}}</td>
                        <td>{{$feedback->content}}</td>
                        <td>
                            <button class="btn btn-primary btn-show"
                            data-content="{{$feedback->content}}"
                            data-url="{{route('ajax-feedback', $feedback->id)}}"
                            data-idFeedback="{{$feedback->id}}"
                            data-toggle="modal"
                            data-target=".modal-detail">Detail</button>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="modal fade modal-detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin feedback</h5>
                </div>
                <div class="modal-body">
                    <span id="content-feedback">Nội dung feedback: </span>
                    <hr>
                    <button class="btn btn-info btn-create-feedback" data-id="" data-target=".modal-list-feedback" data-toggle="modal">Viết feedback</button>
                    <hr>
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Người feedback</th>
                                <th>Nội dung</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-list-feedback" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-list-feedback" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm feedback</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('create-feedback', $id_review)}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" value="" name="id_feedback" id="id_feedback">
                            <textarea class="form-control" name="content" cols="105" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-info">Đăng</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('#list-feedback').dataTable({
                'info': false,
                'order': false,
                'bLengthChange': false
            })
            //=================Overlay modal===================================
            $('.modal').on('show.bs.modal', function(event) {
                var idx = $('.modal:visible').length;
                $(this).css('z-index', 1040 + (10 * idx));
            });
            $('.modal').on('shown.bs.modal', function(event) {
                var idx = ($('.modal:visible').length) -1; // raise backdrop after animation.
                $('.modal-backdrop').not('.stacked').css('z-index', 1039 + (10 * idx));
                $('.modal-backdrop').not('.stacked').addClass('stacked');
            });
            //=================Overlay modal===================================
            $('.btn-show').click(function() {
                var id_feedback = $(this).attr('data-idFeedback');
                $('button.btn-create-feedback').attr('data-id', id_feedback);
                $('input#id_feedback').val(id_feedback);
                var content = $(this).attr('data-content');
                $('#content-feedback').html('Nội dung feedback: <strong>' + content + '</strong>');
                var url = $(this).attr('data-url');
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response) {
                        console.log(response);
                        var output = '';
                        if(response.data.length != 0){
                            for (let i = 0; i < response.data.length; i++) {
                                if(response.data[i].user_id == id){
                                    output += "<tr style='font-weight: 700; background-color: #ffb366'>"+
                                                "<td>"+response.data[i].index+"</td>"+
                                                "<td>"+response.data[i].name+"</td>"+
                                                "<td>"+response.data[i].content+"</td>"+
                                                "<td>"+response.data[i].time+"</td>"
                                            +"</tr>";
                                } else{
                                    output += "<tr>"+
                                                "<td>"+response.data[i].index+"</td>"+
                                                "<td>"+response.data[i].name+"</td>"+
                                                "<td>"+response.data[i].content+"</td>"+
                                                "<td>"+response.data[i].time+"</td>"
                                            +"</tr>";
                                }
                            }
                        } else{
                            output = "<tr style='text-align: center'><th colspan='5'>Chưa có ai trả lời</th></tr>";
                        }
                        $('#table-body').html(output);
                    }
                });
            })
        })
    </script>
@endsection
