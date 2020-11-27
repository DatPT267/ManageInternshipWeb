@extends('admin.layout.index')
@section('content')
    <h1>Danh sách review <strong>{{$name_task}}</strong></h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-create-review">Thêm review</button>

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

    @include('admin.pages.manageTasks.reviews.add-review')
    <table class="table table-hover table-bordered table-striped" id="list-review">
        <thead>
            <tr>
                <th>STT</th>
                <th>Người review</th>
                <th>Nội dung</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $key => $review)
                @if ($review->reviewer_id == Auth::id())
                    <tr style="font-weight: 700; background-color: #ffb366">
                        <td>{{$key}}</td>
                        <td>{{$review->user->name}}</td>
                        <td>{{$review->content}}</td>
                        <td>
                            <a href="{{route('list-feedbackOfTask', $review->id)}}" class="btn btn-info">Detail</a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$review->user->name}}</td>
                        <td>{{$review->content}}</td>
                        <td>
                            <a href="{{route('list-feedback-task', $review->id)}}" class="btn btn-info">Detail</a>
                        </td>
                    </tr>
                @endif

            @endforeach
        </tbody>
    </table>
@endsection
@section('script')
    <script>
        $('#list-review').dataTable({
            'order': false,
            'bLengthChange': false,
            'info' : false
        })
    </script>
@endsection
