<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body{ background:#f5f7fb; font-family:tahoma; }
        .sidebar{ width:250px; min-height:100vh; background:#111827; color:white; position:fixed; right:0; top:0; padding:20px; overflow-y:auto; }
        .sidebar-link{ display:block; color:#cbd5e1; text-decoration:none; padding:10px 15px; border-radius:8px; margin-bottom:5px; }
        .sidebar-link:hover{ background:#1f2937; color:white; }
        .sidebar-link.active{ background:#3b82f6; color:white; }
        .sidebar-sublink{ display:block; color:#cbd5e1; padding:8px 15px; padding-right:30px; text-decoration:none; font-size:14px; }
        .sidebar-sublink:hover{ background:#1f2937; color:white; }
        .sidebar-sublink.active{ color:#fff; font-weight:bold; }
        .arrow{ transition:.3s; }
        .arrow.rotate{ transform:rotate(180deg); }
        .content{ margin-right:250px; padding:20px; min-height:100vh; display:flex; flex-direction:column; }
        .header{ background:white; padding:15px 20px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,.05); margin-bottom:20px; display:flex; justify-content:space-between; align-items:center; }
        .footer{ margin-top:auto; text-align:center; padding:15px; font-size:14px; color:#888; }
        @media (max-width:992px){ .sidebar{ display:none; } .content{ margin-right:0; } }
    </style>
</head>

<body>

@php
    $user = auth()->user();
    $dashboardRoute = 'user.dashboard';
    if ($user && $user->is_superadmin) { $dashboardRoute = 'superadmin.dashboard'; }
    elseif ($user && $user->hasRole('admin')) { $dashboardRoute = 'admin.dashboard'; }

    $coursesOpen = request()->routeIs('superadmin.courses.*');
    $traineesOpen = request()->routeIs('superadmin.trainees.*');
    $usersOpen = request()->routeIs('superadmin.users.*');
    $paymentsOpen = request()->routeIs('superadmin.payments.*');
    $superAdminOpen = request()->routeIs('superadmin.*');
@endphp

<!-- MOBILE MENU -->
<div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header"><h5>پنل مدیریت</h5><button class="btn-close" data-bs-dismiss="offcanvas"></button></div>
    <div class="offcanvas-body p-3">
        <a href="{{ route($dashboardRoute) }}" class="sidebar-link">داشبورد</a>
        
        <a href="#coursesMobile" data-bs-toggle="collapse" class="sidebar-link">دوره‌ها ⌄</a>
        <div class="collapse {{ $coursesOpen ? 'show' : '' }}" id="coursesMobile">
            <a href="{{ route('superadmin.courses.index') }}" class="sidebar-sublink">لیست دوره‌ها</a>
            <a href="{{ route('superadmin.courses.create') }}" class="sidebar-sublink">ایجاد دوره</a>
        </div>

        <a href="#traineesMobile" data-bs-toggle="collapse" class="sidebar-link">کارآموزان ⌄</a>
        <div class="collapse {{ $traineesOpen ? 'show' : '' }}" id="traineesMobile">
            <a href="{{ route('superadmin.trainees.index') }}" class="sidebar-sublink">لیست کارآموزان</a>
            <a href="{{ route('superadmin.trainees.create') }}" class="sidebar-sublink">ایجاد کارآموز</a>
        </div>

        <a href="#usersMobile" data-bs-toggle="collapse" class="sidebar-link">کاربران ⌄</a>
        <div class="collapse {{ $usersOpen ? 'show' : '' }}" id="usersMobile">
            <a href="{{ route('superadmin.users.index') }}" class="sidebar-sublink">لیست کاربران</a>
            <a href="{{ route('superadmin.users.create') }}" class="sidebar-sublink">ایجاد کاربر</a>
        </div>

        <a href="#paymentsMobile" data-bs-toggle="collapse" class="sidebar-link">پرداخت‌ها ⌄</a>
        <div class="collapse {{ $paymentsOpen ? 'show' : '' }}" id="paymentsMobile">
            <a href="{{ route('superadmin.payments.index') }}" class="sidebar-sublink">لیست پرداخت‌ها</a>
            <a href="{{ route('superadmin.payments.create') }}" class="sidebar-sublink">ثبت پرداخت</a>
        </div>
    </div>
</div>

<!-- DESKTOP SIDEBAR -->
<div class="sidebar d-none d-lg-block">
    <h5 class="text-white mb-4">پنل مدیریت</h5>
    <a href="{{ route($dashboardRoute) }}" class="sidebar-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">داشبورد</a>

    <a href="#coursesDesktop" data-bs-toggle="collapse" class="sidebar-link d-flex justify-content-between align-items-center {{ $coursesOpen ? 'active' : '' }}"><span>دوره‌ها</span><span>⌄</span></a>
    <div class="collapse {{ $coursesOpen ? 'show' : '' }}" id="coursesDesktop">
        <a href="{{ route('superadmin.courses.index') }}" class="sidebar-sublink">لیست دوره‌ها</a>
        <a href="{{ route('superadmin.courses.create') }}" class="sidebar-sublink">ایجاد دوره</a>
    </div>

    <a href="#traineesDesktop" data-bs-toggle="collapse" class="sidebar-link d-flex justify-content-between align-items-center {{ $traineesOpen ? 'active' : '' }}"><span>کارآموزان</span><span>⌄</span></a>
    <div class="collapse {{ $traineesOpen ? 'show' : '' }}" id="traineesDesktop">
        <a href="{{ route('superadmin.trainees.index') }}" class="sidebar-sublink">لیست کارآموزان</a>
        <a href="{{ route('superadmin.trainees.create') }}" class="sidebar-sublink">ایجاد کارآموز</a>
    </div>

    <a href="#usersDesktop" data-bs-toggle="collapse" class="sidebar-link d-flex justify-content-between align-items-center {{ $usersOpen ? 'active' : '' }}"><span>کاربران</span><span>⌄</span></a>
    <div class="collapse {{ $usersOpen ? 'show' : '' }}" id="usersDesktop">
        <a href="{{ route('superadmin.users.index') }}" class="sidebar-sublink">لیست کاربران</a>
        <a href="{{ route('superadmin.users.create') }}" class="sidebar-sublink">ایجاد کاربر</a>
    </div>

    <a href="#paymentsDesktop" data-bs-toggle="collapse" class="sidebar-link d-flex justify-content-between align-items-center {{ $paymentsOpen ? 'active' : '' }}"><span>پرداخت‌ها</span><span>⌄</span></a>
    <div class="collapse {{ $paymentsOpen ? 'show' : '' }}" id="paymentsDesktop">
        <a href="{{ route('superadmin.payments.index') }}" class="sidebar-sublink">لیست پرداخت‌ها</a>
        <a href="{{ route('superadmin.payments.create') }}" class="sidebar-sublink">ثبت پرداخت</a>
    </div>

    @if(auth()->check() && auth()->user()->is_superadmin)
        <hr class="text-secondary">
        <a href="#superAdminDesktop" data-bs-toggle="collapse" class="sidebar-link d-flex justify-content-between align-items-center text-warning"><span>پنل ارشد</span><span>⌄</span></a>
        <div class="collapse {{ $superAdminOpen ? 'show' : '' }}" id="superAdminDesktop">
            <a href="{{ route('superadmin.settings') }}" class="sidebar-sublink">تنظیمات پیامک</a>
        </div>
    @endif
</div>

<div class="content">
    <div class="header">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">☰</button>
            <h5 class="mb-0">@yield('page_title')</h5>
        </div>
        <div>
            <span class="me-3">{{ auth()->user()->name ?? 'مدیر' }}</span>
            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-sm btn-danger">خروج</a>
            <form id="logout-form" action="{{ route('superadmin.logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
    <div class="flex-grow-1">@yield('content')</div>
    <div class="footer">© {{ date('Y') }} پنل مدیریت</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
