@extends('user.layout.index')
@section('content')
    {{-- <h1 style="text-align: center">infomation User</h1> --}}
    <div style="margin: 0 20%;">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{$error}}
                @endforeach
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif
        @if (session('fail'))
            <div class="alert alert-danger">
                {{session('fail')}}
            </div>
        @endif
        <form action="{{route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
            <center>
            <img src="uploads/{{$user->image}}" name="aboutme" width="200" height="200" class="avatar img-circle">
            <h3 class="media-heading">
                {{$user->name}}
                <small>
                    @if ($user->status == 1)
                        <span class="label label-success">Active</span>
                    @else
                        <span class="label label-danger">Not Active</span>
                    @endif
                </small>
            </h3>
            </center>
            <hr>
            @csrf
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control file-upload" name="image" id="image">
            </div>
            <div class="form-group">
                <label for="account">Account</label>
                <input type="email" id="account" disabled class="form-control" name="account" value="{{$user->account}}">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" name="name" value="{{$user->name}}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" name="email" value="{{$user->email}}">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" class="form-control" name="phone" value="{{$user->phone}}">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" class="form-control" name="address" value="{{$user->address}}">
            </div>
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" id="position" class="form-control" name="position" value="{{$user->position}}">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Internship class: </label>
                <input type="text" class="form-control" disabled value="{{$user->internshipClass->name}}">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.avatar').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".file-upload").on('change', function(){
                readURL(this);
            });
        });
    </script>
@endsection
