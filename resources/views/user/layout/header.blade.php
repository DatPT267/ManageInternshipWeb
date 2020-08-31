<div class="header delay">
    <div class="container">
        <div class="logo delay">
        <a href="{{route('home')}}">

                <img src="image/logo.png" alt="TRANG CHỦ" title="TRANG CHỦ" class="delay" width="70" height="70">

            </a>
        </div>
        <div class="menu delay">
            <nav id="mainMenu">
                <ul class="mainMenu delay">
                        <li><a href="trangchu" title="Trang chủ">Trang chủ</a></li>
                        <li>
                            <a href="" title="Quản lý">Quản Lý</a>
                                <ul class="subMenu">
                                    <li><a href="" title="Bài tập">Bài tập</a></li>
                                    <li><a href="" title="Check">Checkin - checkout</a></li>
                                    <li><a href="" title="Lịch đăng kí thực tập">Lịch đăng kí thực tập</a></li>
                                </ul>
                        </li>
                        @if (Auth::check())
                        <li>
                            <a href="" title="Nhóm">Nhóm</a>
                            <ul class="subMenu">
                                <li><a href="/user/{{Auth::id()}}/list-group" title="Dự án">Danh sách nhóm</a></li>
                                <li><a href="" title="Thành viên">Thành viên</a></li>
                            </ul>
                        </li>
                        @endif
                        <li>
                            <a href="" title="">Thông tin cá nhân</a>
                        </li>
                        <li>
                            <a href="" title="">Đánh giá</a>

                        </li>
                </ul>
            </nav>
            <button id="button-toggle-menu" class="visible-xs"><i class="fa fa-bars"></i></button>
        </div>
        <div class="leng-item">
            <ul class="ul">
                <li>
                <a href="javascript:void(0)" class="on-serach"><img src="image/search3.png" style="margin-top: 3px;" class="dropdown-toggle" data-toggle="dropdown"></a>
                    <div class="show-serach delay">
                        <div class="search">
                            <form action="tim-kiem">
                                <input type="text" name="q" class="form-control input-sm" maxlength="64" placeholder="Tìm kiếm" />
                                <button type="submit" class="btn btn-sm">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                </li>
                <li>
                        <img src="image/user.png" style="margin-top: 3px;"  data-toggle="dropdown">
                        @if(Auth::check())
                        <ul class="dropdown-menu">
                            <li style="color: black;padding:10px;">Xin chào, {{Auth::user()->name}}</li>
                            <li><a href="thongtintaikhoan" title="Thông tin tài khoản">Thông tin tài khoản</a></li>
                            <li><a href="{{ route('logout') }}" class="log-out-acc" title="Đăng xuất">Đăng Xuất</a></li>
                        </ul>
                        @else
                        <ul class="dropdown-menu">
                            <li><a href="admin/login">Quản trị</a></li>
                            <li><a href="#login">Thành viên</a></li>
                        </ul>
                        @endif

                </li>
                <li><img src="image/phone1.png" style="margin-top: 3px;" class="dropdown-toggle" data-toggle="dropdown"><span> <a href="tel:0773354138">0773.354.138</a></span></li>
            </ul>
        </div>
    </div>


    <!-- popup đăng nhập -->
    <div class="remodal" data-remodal-id="login" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc" data-remodal-options="closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
        <div class="register">
            <form  method="post" action="login"  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <h3>Chào mừng bạn quay trở lại!</h3>
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
                <div class="form-group">
                    <label class="control-label pull-left">Tài Khoản</label>
                    <input type="text"  name="account" class="form-control input-lg" />
                    <i class="" aria-hidden="true"></i>
                </div>
                <div class="form-group">
                    <div class="clearfix">
                        <label class="control-label pull-left">MẬT KHẨU</label>
                        <div class="pull-right"></div>
                    </div>
                    <input type="password" name="password" class="form-control input-lg" />
                    <i class="" aria-hidden="true"></i>
                </div>
                <div class="form-group text-center">
                    <ul class="ul over">
                        <li><button type="submit" id="log-acc" class="btn btn-green">Đăng nhập</button></li>

                        <li><b style="font-weight: 600"><a href="#forgot-password" title="Khôi phục mật khẩu" class="color-green pull-right">Quên mật khẩu</a></b></li>
                    </ul>
                </div>
                <input type="hidden" name="urlback" />
            </form>
        </div>
    </div>
    <!-- end popup đăng nhập -->

     <!-- quên pass -->
    <div class="remodal" data-remodal-id="forgot-password" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc" data-remodal-options="closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
        <div class="register">
            <form id="form-forgot-pass" action="losspassword" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <h3>Khôi phục mật khẩu</h3>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="text" name="email" id="forgotPassEmail" class="form-control input-lg" />

                </div>
                <div class="form-group text-center">
                    <ul class="ul over">
                        <li><button type="submit" id="btn-send-forgot-pass" class="btn btn-lg btn-block btn-green">Gửi đi</button></li>
                    <li><b style="font-weight: 600"><a href="#login" title="" class="color-green" style="font-size: 13.4px">Đăng nhập tại đây</a></b></li>
                    </ul>
                </div>

            </form>
        </div>
    </div>
    <!-- end popup quên pass -->

</div>


</div>
<script>
    $(function () {
        $("#btnSearch").click(function () {
            if ($("#frmSearch").valid()) {
                $("#frmSearch").submit();
            }
        });
        $("#frmSearch").validate({
            rules: {
                district_choice: {
                    required: true
                },
                date: {
                    required: true
                },
                //time_zone: {
                //    required: true
                //},
            },
            messages: {
                district_choice: {
                    required: "*",
                },
                date: {
                    required: "*",
                },
                //time_zone: {
                //    required: "*",
                //},
            }
        });
        $("#district_choice").change(function () {
            var city = $(this).val();
            if (city == '')
                city = 0;
            $.post("/Ajax/Home/GetListField", { ID: city }, function (data) {
                //var html = '';
                //$.each(data, function (i, item) {
                //    html += '<option value="' + item.ID + '">' + item.Name + '</option>';
                //});
                //$("#field_choice").empty();
                //$("#field_choice").append('<option value="">Chọn sân</option>');
                $("#field_choice").html(data);
            });
        });


    });

</script>


<style>
    .voic i {
        position: absolute;
        top: 12px;
        right: 11px;
    }
</style>
