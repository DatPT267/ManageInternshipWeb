<html>
<head>
<title>Quên mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="../authentication/css/losspass.css">
<body>
    <div class="loginbox col-sm-6" >
        
        <h1>Đặt Lại mật khẩu</h1>
        <p style="text-align: center">Vui lòng nhập email để lấy lại mật khẩu</p>
        @if(count($errors)>0)
            <div class="alert alert-danger" style="text-align: center">
                @foreach($errors->all() as $err)
                    {{$err}} <br>
                @endforeach
            </div>
        @endif
        <div style="text-align: center">
            @if(session('thongbao'))
                {{session('thongbao')}}
            @endif
        </div>
        <form role="form" action="../user/losspassword" method="POST" >
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            
            <input type="text" name="email">
            <br>

            <input  type="submit" name="" value="Gửi">
            
            <a href="{{ route('login') }}">
                <input  type="button" value="Đăng Nhập" >
            </a>
        </form>
           
    </div>

</body>
</head>
</html>