<html>
<head>
<title>Đăng Nhập</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('authentication/css/style.css') }}">
<body>
    <div class="loginbox">
    <img src="{{ asset('authentication/images/avatar.png') }}" class="avatar">
        <h1>Vui Lòng Đăng Nhập</h1>
        <form role="form" action="{{ route('login')}}" method="POST">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <p>Tài Khoản</p>
            <input type="text" name="account" value="{{ old('account') }}" placeholder="Tên đăng nhập">
            <p>Mật Khẩu</p>
            <input type="password" name="password" placeholder="Mật khẩu">
            <input type="submit" name="" value="Đăng Nhập">
        </form>
        @if(count($errors)>0)
        <div class="alert alert-danger" style="text-align: center">
            @foreach($errors->all() as $err)
                {{$err}} <br>
            @endforeach
        </div>
        @endif
        <div  class="alert alert-danger" style="text-align: center">
            @if(session('thongbao'))
                {{session('thongbao')}}
            @endif
        </div>
        <a href="{{ route('losspassword') }}">Quên Mật Khẩu?</a><br>
    </div>
</body>
</head>
</html>
