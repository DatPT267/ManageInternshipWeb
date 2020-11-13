<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fab fa-audible"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/admin">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#QLDot" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Quản lý đợt thực tập</span>
        </a>
        <div id="QLDot" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{--
                <h6 class="collapse-header">Custom Components:</h6>
                --}}
                <a class="collapse-item" href="{{route('internshipClass.index')}}">Danh sách đợt thực tập</a>
                <a class="collapse-item" href="{{route('internshipClass.create')}}">Thêm đợt thực tập</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#QLSV" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Quản lý sinh viên</span>
        </a>
        <div id="QLSV" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{--
                <h6 class="collapse-header">Custom Components:</h6>
                --}}
                <a class="collapse-item" href="{{route('manageStudents.index')}}">Danh sách sinh viên</a>
                <a class="collapse-item" href="{{route('manageStudents.create')}}">Thêm sinh viên</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#QLTask" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Quản lý task</span>
        </a>
        <div id="QLTask" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{--
                <h6 class="collapse-header">Custom Components:</h6>
                --}}
                <a class="collapse-item" href="{{route('manageTask.index')}}">Danh sách task</a>
                <a class="collapse-item" href="{{route('manageTask.create')}}">Thêm task</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#QLNhom" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Quản lý Nhóm</span>
        </a>
        <div id="QLNhom" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{--
                <h6 class="collapse-header">Custom Components:</h6>
                --}}
                <a class="collapse-item" href="{{route('manageGroup.index')}}">Danh sách nhóm</a>
                <a class="collapse-item" href="{{route('manageGroup.create')}}">Thêm nhóm</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#QLLichTT" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Lịch thực tập</span>
        </a>
        <div id="QLLichTT" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{--
                <h6 class="collapse-header">Custom Components:</h6>
                --}}
                <a class="collapse-item" href="{{route('list-schedule.index')}}">Danh sách đăng ký</a>
                <a class="collapse-item" href="{{route('statistical.checkin-out')}}">Thống kê checkin-checkout</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#QLGVHD" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Quản lý GV hướng dẫn</span>
        </a>
        <div id="QLGVHD" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{--
                <h6 class="collapse-header">Custom Components:</h6>
                --}}
                <a class="collapse-item" href="{{route('manageLecturer.index')}}">Danh sách giảng viên</a>
                <a class="collapse-item" href="{{route('manageLecturer.create')}}">Thêm giảng viên</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
