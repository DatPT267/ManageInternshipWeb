<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Admin - QLThucTap</title>
        <base href="{{asset('')}}">
        <!-- Custom fonts for this template-->
        <link href="{{ asset('admin_asset/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('admin_asset/vendor/datatables/dataTables.bootstrap4.min.css') }}">
        <!-- Custom styles for this template-->
        <link href="{{ asset('admin_asset/css/sb-admin-2.min.css') }}" rel="stylesheet">
        @yield('style')
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
                        {{-- @include('admin.inc.bang') --}}
                        @yield('content')
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
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="/">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
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
