<html>
<head>
<title>Quên mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="../authentication/css/losspass.css">
<body>
    <div class="loginbox col-sm-6" >
        
        <h1>Đặt Lại mật khẩu</h1>
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
        <form role="form" action="../admin/losspassword" method="POST" >
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <p>Vui lòng nhập email để lấy Lại mật khẩu của bạn</p>
            <input type="text" name="email">
            <br>

            <input  type="submit" name="" value="Gửi">
        </form>
           
    </div>

</body>
</head>
</html>