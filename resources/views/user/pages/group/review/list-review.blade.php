@extends('user.layout.index')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1>Danh sách đánh giá <strong>{{$group->name}}</strong></h1>
                <table class="table table-bordered table-hover table-striped" id="list-review">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Nội dung</th>
                            <th>Người đánh giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($reviews) > 0)
                            @foreach ($reviews as $key => $review)
                                <tr {{ $review->reviewer->id == Auth::id() ? "style='font-weight: 700;'" : "" }}>
                                    <td>{{$key+1}}</td>
                                    <td >{{$review->content}}</td>
                                    <td >{{$review->reviewer->name}}</td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-info btn-circle btn-show-review"
                                                data-url="{{route('ajax-detail-review')}}"
                                                data-id="{{$review->id}}"
                                                data-content-review="{{$review->content}}"
                                                data-reviewer="{{$review->reviewer->name}}"
                                                data-toggle="modal"
                                                data-target=".bd-example-modal-xl"><i class="fas fa-info-circle"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4"><strong>Chưa ai review</strong></td>
                            </tr>
                        @endif
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
                                        <table class="table table-bordered table-striped ">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Nội dung feedback</th>
                                                    <th>Tên người feeback</th>
                                                    <th>Thời gian feedback</th>
                                                </tr>
                                            </thead>
                                            <tbody id="list-feedback"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
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
                                    <input type="hidden" name="group_id" id="group_id" value="{{ $group->id }}">
                                    <input type="hidden" name="review_id" id="review_id" value="">
                                    <div class="form-group">
                                        <textarea name="content" class="form-control" cols="105" rows="5" placeholder="Viết feedback"></textarea><br>
                                        <button type="submit" class="btn btn-success">Đăng</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
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

            function checkAuthor($reviewer_id){
                if ($reviewer_id == "{{ Auth::id() }}") {
                    return "font-weight: 700";
                }
                return "";
            }

            $('.btn-show-review').click(function (){
                var url = $(this).attr('data-url');
                var id = $(this).attr('data-id');
                $('#review_id').val(id);
                $('#content-review').text($(this).attr('data-content-review'));
                $('#reviewer').text($(this).attr('data-reviewer'));

                var idUser = "{{Auth::id()}}";
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {id: id},
                    success: function (response) {
                        console.log(response);
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
                        $('#list-feedback').html(output)
                    }
                });
            })
        })
    </script>
@endsection
