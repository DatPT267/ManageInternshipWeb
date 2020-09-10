<!DOCTYPE html>
<html>
<head>
    <title>TRANG CHỦ</title>
    <meta name="description" content="TRANG CHỦ" />
    <meta name="keywords" content="TRANG CHỦ" />
    <meta name="robots" content="noodp,index,follow" />
    <meta name='revisit-after' content='1 days' />
    <meta property="og:image" />
    <meta property="og:title" content="TRANG CHỦ" />
    <meta property="og:description" content="TRANG CHỦ" />
    <meta property="og:site_name" content="Nasol" />
    <meta property="og:url" content="/" />
    <meta property="og:type" content="article" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="utf-8">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <base href="{{asset('')}}">
    <!--css-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin,vietnamese' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/jquery.simplyscroll.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/jquery.mmenu.all.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/owl.transitions.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/remodal.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/remodal-default-theme.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/bootstrap-datepicker.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/sweetalert.css">
    <link href="admin_asset1/css/Content/Admin/theme/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/style.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/layout.css">
    <link rel="stylesheet" type="text/css" href="admin_asset1/css/Content/html/css/reponsive.css">
    <link href="admin_asset1/css/Content/Publishing/css/jquery.datetimepicker.css" rel="stylesheet" />
    <link href="admin_asset1/css/Content/Admin/Bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />


    <script type="text/javascript" src="admin_asset1/css/Content/html/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/jquery.mmenu.min.all.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/remodal.min.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/jquery.timepicker.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/slick.min.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/member.js"></script>
    <script src="admin_asset1/css/Content/Publishing/js/jquery.form.min.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/jquery.validate.min.js"></script>
    <script src="admin_asset1/css/Content/Admin/theme/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="admin_asset1/css/Content/Admin/theme/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/sweetalert.min.js"></script>
    <script src="admin_asset1/css/Content/Admin/js/jquery.address-1.6.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/html/js/javascript.js"></script>
    <script type="text/javascript" src="admin_asset1/css/Content/Publishing/js/LoadData.js"></script>
    <script src="admin_asset1/css/Content/Admin/Bootstrap/js/bootstrap-datetimepicker.min.js"></script>
    <script src="admin_asset1/css/Content/Publishing/js/jquery.datetimepicker.full.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

</head>
<body>
    <div id="fb-root"></div>
    <script>
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "admin_asset1/css/connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=612720708938941";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    @include('user.layout.header')
    <div class="wrapper">
        @include('user.layout.timkiem')

        @yield('content')

    </div>
    <script>
        $(function () {
            $(".ClosePopup")
                .click(function () {
                    $("#showPop").addClass("display");
                });
        });
    </script>
    <style>
        .display {
            display: none;
        }

    </style>

        <!-- slyder-home -->
        <!-- footer -->

<!-- footter -->
    @include('user.layout.footer')
<!-- end footter -->

        <!-- end footer -->
    </div>

    <a href="#" class="delay gotop bg"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    <script type="text/javascript">
        (function () {
            $(window).scroll(function () {
                if ($(window).scrollTop() == 0) {
                    $('.gotop').stop(false, true).fadeOut(600);
                } else {
                    $('.gotop').stop(false, true).fadeIn(600);
                }
            });
            $('.gotop').click(function () {
                $('body,html').animate({ scrollTop: 0 }, 400);
                return false;
            });
        })(jQuery);
    </script>


    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date(); a = s.createElement(o),
            m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-97001872-1', 'auto');
        ga('send', 'pageview');

    </script>
    <script type="text/javascript" src="admin_asset1/css/s7.addthis.com/js/300/addthis_widget.js#pubid=ra-546c6a3a3551dec6"></script>
    @yield('script')
</body>
</html>

