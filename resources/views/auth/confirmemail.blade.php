<html>
<head>

    <title>Quên mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('authentication/css/losspass.css') }}">
<body>
    <div class="loginbox col-sm-6" >

        <h1>Đây có phải tài khoản của bạn</h1>
        <div style="text-align: center">
            @if(session('thongbao'))
                {{session('thongbao')}}
            @endif
        </div>
    <form role="form" action="{{ route('sendMail', $user->email) }}" method="POST">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        <p>Email:           &ensp; &ensp;&ensp;{{ $user->email }}</p>
            <br>
            <hr>
            <br>
        <p>Tên Người Dùng:&ensp; &ensp;{{$user->name}}</p> <img src="{{ asset('image/user/') }}{{ $user->image }}" class="avatar">

            <br>
            <input type="submit" name="" value="Đặt Lại mật khẩu">

        </form>

    </div>

</body>
</head>
</html>
