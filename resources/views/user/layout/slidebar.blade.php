<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fab fa-audible"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            @if (Auth::user()->position === 1)
                USER
            @else
                ADMIN
            @endif
        </div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.listGroup', Auth::id())}}">
            <i class="fas fa-list"></i>
            <span>Danh sách nhóm tham gia</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#QLSV" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-tasks"></i>
        <span>Quản lý task</span>
        </a>
        <div id="QLSV" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Danh sách task</a>
                <a class="collapse-item" href="#">Thêm task</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.regSchedule', Auth::id())}}">
            <i class="fas fa-calendar-alt"></i>
        <span>Đăng ký lịch thực tập</span></a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#checkinOut" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-check"></i>
        <span>Checkin - Checkout</span>
        </a>
        <div id="checkinOut" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('checkin', Auth::user()->id)}}">Checkin</a>
                <a class="collapse-item" href="{{route('checkout', Auth::user()->id)}}">Checkout</a>
                <a class="collapse-item" href="{{route('user.hisSchedule', Auth::user()->id)}}">Lịch sử thực tập</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('list-review-of-user', Auth::id())}}">
            <i class="fas fa-list"></i>
        <span>Danh sách đánh giá</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
