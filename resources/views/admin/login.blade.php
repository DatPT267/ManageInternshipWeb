<html>
<head>
<title>Đăng Nhập</title>
    <link rel="stylesheet" type="text/css" href="../authentication/css/style.css">
<body>
    <div class="loginbox">
    <img src="../authentication/images/avatar.png" class="avatar">
        <h1>Vui Lòng Đăng Nhập</h1>
        <form role="form" action="admin/login" method="POST">
            <p>Tài Khoản</p>
            <input type="text" name="" placeholder="">
            <p>Mật Khẩu</p>
            <input type="password" name="" placeholder="">
            <input type="submit" name="" value="Login">
            <a href="{{ route('losspassword') }}">Quên Mật Khẩu?</a><br>   
        </form>  
    </div>
</body>
</head>
</html>