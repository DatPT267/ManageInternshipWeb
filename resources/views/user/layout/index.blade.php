<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Admin - QLThucTap</title>
        <!-- Custom fonts for this template-->
        <link href="{{ asset('admin_asset/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('admin_asset/vendor/datatables/dataTables.bootstrap4.min.css') }}">
        <!-- Custom styles for this template-->
        <link href="{{ asset('admin_asset/css/sb-admin-2.min.css') }}" rel="stylesheet">
        @toastr_css
    </head>
    <body id="page-top">
        <div id="wrapper">
            @include('user.layout.slidebar')
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    @include('user.layout.navbar')
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                {{-- @include('user.layout.footer') --}}
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        @include('user.layout.logout')
        <!-- Bootstrap core JavaScript-->
        @jquery
        @toastr_js
        @toastr_render
        <script src="{{ asset('admin_asset/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin_asset/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin_asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        {{-- datatables javascripts --}}
        <script src="{{ asset('admin_asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin_asset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Core plugin JavaScript-->
        <script src="{{ asset('admin_asset/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('admin_asset/js/sb-admin-2.min.js') }}"></script>

        @yield('script')
    </body>
</html>
