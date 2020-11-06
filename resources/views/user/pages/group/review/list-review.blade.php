@extends('user.layout.index')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1>Danh sách review <strong>{{$groupName}}</strong></h1>
                <table class="table table-bordered table-hover" id="list-review">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Nội dung</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $key => $review)
                            <tr >
                                <td>{{$key+1}}</td>
                                <td >{{$review->member->user->name}}</td>
                                <td >{{$review->content}}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-primary btn-show-review"
                                            data-url="{{route('ajax-detail-review')}}"
                                            data-id="{{$review->id}}"
                                            data-content-review="{{$review->content}}"
                                            data-reviewer="{{$review->member->user->name}}"
                                            data-toggle="modal"
                                            data-target=".bd-example-modal-xl">Detail</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Thông tin đánh giá</h5>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-3">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Thêm feedback</button>
                                        </div>
                                        <div class="col-9">
                                            <span>Nội dung: <strong id="content-review">review 1</strong></span><br>
                                            <span>Người review: <strong id="reviewer">admin</strong></span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <table class="table table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên người feeback</th>
                                                    <th>Nội dung feedback</th>
                                                    <th>Thời gian feedback</th>
                                                </tr>
                                            </thead>
                                            <tbody id="list-feedback" style="color: black"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Thêm feedback</h5>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('post-create-feedback', Auth::id())}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="id_review" id="id_review" value="">
                                        <textarea name="content" class="form-control" cols="105" rows="5" placeholder="Viết feedback"></textarea><br>
                                        <button type="submit" class="btn btn-success">Đăng</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        @foreach ($errors->all() as $error)
            toastr.warning("{{ $error }}")
        @endforeach
    </script>
    <script>
        $(document).ready(function (){

            $('#list-review').dataTable({
                'bLengthChange': false,
                'info': false,
                'columns': [
                    {'orderable': true},
                    {'orderable': false},
                    {'orderable': false},
                    {'orderable': false},
                ]
            });

            $('.modal').on('show.bs.modal', function(event) {
                var idx = $('.modal:visible').length;
                $(this).css('z-index', 1040 + (10 * idx));
            });
            $('.modal').on('shown.bs.modal', function(event) {
                var idx = ($('.modal:visible').length) -1; // raise backdrop after animation.
                $('.modal-backdrop').not('.stacked').css('z-index', 1039 + (10 * idx));
                $('.modal-backdrop').not('.stacked').addClass('stacked');
            });


            $('.btn-show-review').click(function (){
                var url = $(this).attr('data-url');
                var id = $(this).attr('data-id');
                $('#id_review').val(id);
                $('#content-review').text($(this).attr('data-content-review'));
                $('#reviewer').text($(this).attr('data-reviewer'));

                var idUser = "{{Auth::id()}}";
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {id: id},
                    success: function (response) {
                        console.log(response);
                        var output = '';
                        if(response.data.length != 0){
                            for (let i = 0; i < response.data.length; i++) {
                                if(response.data[i].id == idUser){
                                    output += "<tr style='background-color: #0084FF'>"+
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
                        }else{
                            output = "<tr><th colspan='4' class='text-center'>Chưa có ai trả lời</th></tr>";
                        }
                        $('#list-feedback').html(output);
                    }
                });
            })
        })
    </script>
@endsection
