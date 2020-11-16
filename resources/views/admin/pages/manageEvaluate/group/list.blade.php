@extends('admin.layout.index')
@section('content')
    <h1>Danh sách Review của nhóm <strong>{{ $group->name }}</strong></h1>
    <!-- Large modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Thêm review</button>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    Thêm review
                </div>
                <div class="modal-body">
                    <form action="{{ route('post.group.store-group') }}" method="post" id="form-create-review">
                        @csrf
                        <input type="hidden" name="group_id" id="group_id" value="{{ $group->id }}">
                        <div class="form-group">
                            <label for="content">Nội dung: </label>
                            <textarea class="form-control" name="content" id="content" cols="30" rows="3" placeholder="Viết nội dung cho review"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Thêm</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered table-hover" id="list-review">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nội dung</th>
                <th>Người đánh giá</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $index = 0;
            @endphp
            @foreach ($reviews as $review)
            <tr style="{{ $review->reviewer_id == Auth::id() ? "font-weight: 700" : '' }}">
                <td>{{++$index}}</td>
                <td>{{$review->content}}</td>
                <td>{{$review->reviewer->name}}</td>
                <td>
                <button type="button" class="btn btn-info btn-circle" data-toggle="modal" data-target="#exampleModalScrollable" id="btn-replies" data-idReview="{{ $review->id }}" data-url="{{ route('group.getListReply', $review->id) }}">
                        <i class="fas fa-info-circle"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Danh sách replies</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".create-reply">Thêm reply</button>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nội dung</th>
                                <th>Người đánh giá</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody id="show-reply">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade create-reply" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    Thêm reply
                </div>
                <div class="modal-body">
                    <form action="{{ route('post.group.store-reply') }}" method="post" id="form-create-reply">
                        @csrf
                        <input type="hidden" name="group_id" id="group_id1" value="{{ $group->id }}">
                        <input type="hidden" name="review_id" id="review_id" value="">
                        <div class="form-group">
                            <label for="content-reply">Nội dung: </label>
                            <textarea class="form-control" name="content" id="content-reply" cols="30" rows="3" placeholder="Viết nội dung cho review"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Thêm</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
@endsection
@section('script')
    <script>

        $(document).ready(function(){
            $('.modal').on('show.bs.modal', function(event) {
                var idx = $('.modal:visible').length;
                $(this).css('z-index', 1040 + (10 * idx));
            });
            $('.modal').on('shown.bs.modal', function(event) {
                var idx = ($('.modal:visible').length) -1; // raise backdrop after animation.
                $('.modal-backdrop').not('.stacked').css('z-index', 1039 + (10 * idx));
                $('.modal-backdrop').not('.stacked').addClass('stacked');
            });

            $('#list-review').dataTable({
                'info': false,
                'bLengthChange': false
            });

            function checkAuthor($reviewer_id){
                if ($reviewer_id == "{{ Auth::id() }}") {
                    return "font-weight: 700";
                }
                return "";
            }
            $('button#btn-replies').click(function (){
                var url = $(this).attr('data-url');
                $('#review_id').val($(this).attr('data-idReview'));
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    success: function (response) {
                        var output = "";
                        if(response.data.length != 0){
                            for (let i = 0;i < response.data.length; i++) {
                                output += "<tr style='"+checkAuthor(response.data[i]['reviewer_id'])+"'>"+
                                    "<td>"+response.data[i]['index']+"</td>"+
                                    "<td>"+response.data[i]['content']+"</td>"+
                                    "<td>"+response.data[i]['name']+"</td>"+
                                    "<td>"+response.data[i]['time']+"</td>"
                                +"</tr>";
                                output = output.replace(':id', response.data[i]['id']);
                            }
                        } else{
                            output = "<tr><td  colspan='4' align='center'><strong>Chưa có ai reply</strong></td></tr>";
                        }
                        $('#show-reply').html(output)
                    }
                });
            });

            $('#form-create-reply').validate({
                rules: {
                    'content': {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    'content': {
                        required: "Bạn chưa nhập nội dung",
                        minlength: "Nội dung phải trên 3 kí tự"
                        // filesize: "Ảnh có kích thước tối đa là 10MB"
                    }
                }
            });
            $('#form-create-review').validate({
                rules: {
                    'content': {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    'content': {
                        required: "Bạn chưa nhập nội dung",
                        minlength: "Nội dung phải trên 3 kí tự"
                        // filesize: "Ảnh có kích thước tối đa là 10MB"
                    }
                }
            });
        })
    </script>
@endsection
