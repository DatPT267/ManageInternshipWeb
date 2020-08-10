<div class="header delay">
    <div class="container">
        <div class="logo delay">
            <a href="/SanBongWeb/public/trangchu">

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
                        <li>
                            <a href="" title="Nhóm">Nhóm</a>
                            <ul class="subMenu">
                    
                                        <li><a href="" title="Dự án">Dự án</a></li>  
                                        <li><a href="" title="Thành viên">Thành viên</a></li>
                                </ul>
                        </li>
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
                        @else
                        <ul class="dropdown-menu">
                            <li><a href="dangnhap">Quản trị</a></li>
                            <li><a href="trangchu#login">Thành viên</a></li>
                        </ul>
                        @endif
                   
                </li>
                <li><img src="image/phone1.png" style="margin-top: 3px;" class="dropdown-toggle" data-toggle="dropdown"><span> <a href="tel:0917665155">0773.354.138</a></span></li>
            </ul>
        </div>
    </div>
    <!-- popup đăng ký -->
   
    <!-- popup đăng nhập -->
    <div class="remodal" data-remodal-id="login" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc" data-remodal-options="closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
        <div class="register">
            <form  method="post" action="dangnhap"  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <h3>Chào mừng bạn quay trở lại!</h3>
                <div class="form-group">
                    <label class="control-label pull-left">EMAIL</label>
                    <input type="text"  name="email" class="form-control input-lg" />
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