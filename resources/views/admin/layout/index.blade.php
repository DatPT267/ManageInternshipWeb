<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin - QLThucTap</title>
        <base href="{{asset('')}}">
        <!-- Custom fonts for this template-->
        <link href="{{ asset('admin_asset/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('admin_asset/vendor/datatables/dataTables.bootstrap4.min.css') }}">
        <!-- Custom styles for this template-->
        <link href="{{ asset('admin_asset/css/sb-admin-2.min.css') }}" rel="stylesheet">
        @yield('style')
        <style>
            .error{
                font-size: 1rem !important;
                color: red !important;
                width: 100% !important;
            }
        </style>
        <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    </head>
    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">

            {{-- begin slidebar --}}
            @include('admin.layout.slidebar')
            {{-- end slidebar --}}

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    {{-- begin nav --}}
                    @include('admin.layout.navbar')
                    {{-- end nav --}}
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <!-- Page Heading -->
                        @yield('content')
                        <!-- Page Heading -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
                {{-- begin footer --}}
                @include('admin.layout.footer')
                {{-- end footer --}}
                {{--  --}}
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->

        @include('admin.layout.logout')
        <!-- Bootstrap core JavaScript-->
        <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
        <script src="{{ asset('admin_asset/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin_asset/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin_asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        {{-- datatables javascripts --}}
        <script src="{{ asset('admin_asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin_asset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

        @yield('script')
        <script>
            @foreach ($errors->all() as $error)
                toastr.warning("{{$error}}")
            @endforeach
        </script>
        <!-- Core plugin JavaScript-->
        <script src="{{ asset('admin_asset/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('admin_asset/js/sb-admin-2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    </body>
</html>
