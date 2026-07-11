<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'پنل ادمین')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background: #f5f7fb;
            font-family: Tahoma, sans-serif;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #0f172a;
            color: white;
            position: fixed;
            right: 0;
            top: 0;
            padding: 20px;
            overflow-y: auto;
            z-index: 1030;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #fff;
        }

        .sidebar-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #cbd5e1;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 6px;
            transition: 0.2s ease;
        }

        .sidebar-link:hover {
            background: #1e293b;
            color: white;
        }

        .sidebar-link.active {
            background: #2563eb;
            color: white;
        }

        .sidebar-sublink {
            display: block;
            color: #cbd5e1;
            padding: 8px 15px;
            padding-right: 35px;
            text-decoration: none;
            font-size: 14px;
            border-radius: 8px;
            margin-bottom: 4px;
            transition: 0.2s ease;
        }

        .sidebar-sublink:hover {
            background: #1e293b;
            color: white;
        }

        .sidebar-sublink.active {
            background: rgba(59, 130, 246, 0.15);
            color: #fff;
            font-weight: bold;
        }

        .content {
            margin-right: 260px;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer {
            margin-top: auto;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #888;
        }

        .menu-arrow {
            font-size: 12px;
            opacity: 0.8;
        }

        .user-name {
            font-weight: 600;
            color: #374151;
        }

        @media (max-width: 992px) {
            .sidebar {
                display: none;
            }

            .content {
                margin-right: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
@php
    $dashboardRoute = 'admin.dashboard';

    $coursesOpen = request()->routeIs('admin.courses.*');
    $traineesOpen = request()->routeIs('admin.trainees.*');
    $paymentsOpen = request()->routeIs('admin.payments.*');
    $examsOpen = request()->routeIs('admin.exams.*');
@endphp

<!-- MOBILE MENU -->
<div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
        <h5 class="mb-0">پنل ادمین</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-3">
        <a href="{{ route($dashboardRoute) }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span>داشبورد</span>
        </a>

        <a href="#coursesMobile" data-bs-toggle="collapse" class="sidebar-link {{ $coursesOpen ? 'active' : '' }}">
            <span>دوره‌ها</span>
            <span class="menu-arrow">⌄</span>
        </a>
        <div class="collapse {{ $coursesOpen ? 'show' : '' }}" id="coursesMobile">
            <a href="{{ route('admin.courses.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.courses.index') ? 'active' : '' }}">لیست دوره‌ها</a>
        </div>

        <a href="#traineesMobile" data-bs-toggle="collapse" class="sidebar-link {{ $traineesOpen ? 'active' : '' }}">
            <span>کارآموزان</span>
            <span class="menu-arrow">⌄</span>
        </a>
        <div class="collapse {{ $traineesOpen ? 'show' : '' }}" id="traineesMobile">
            <a href="{{ route('admin.trainees.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.trainees.index') ? 'active' : '' }}">لیست کارآموزان</a>
            <a href="{{ route('admin.trainees.create') }}" class="sidebar-sublink {{ request()->routeIs('admin.trainees.create') ? 'active' : '' }}">ایجاد کارآموز</a>
        </div>

        <a href="#paymentsMobile" data-bs-toggle="collapse" class="sidebar-link {{ $paymentsOpen ? 'active' : '' }}">
            <span>پرداخت‌ها</span>
            <span class="menu-arrow">⌄</span>
        </a>
        <div class="collapse {{ $paymentsOpen ? 'show' : '' }}" id="paymentsMobile">
            <a href="{{ route('admin.payments.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.payments.index') ? 'active' : '' }}">لیست پرداخت‌ها</a>
            <a href="{{ route('admin.payments.create') }}" class="sidebar-sublink {{ request()->routeIs('admin.payments.create') ? 'active' : '' }}">ثبت پرداخت</a>
        </div>

        @if(Route::has('admin.exams.index'))
            <a href="#examsMobile" data-bs-toggle="collapse" class="sidebar-link {{ $examsOpen ? 'active' : '' }}">
                <span>آزمون‌ها</span>
                <span class="menu-arrow">⌄</span>
            </a>
            <div class="collapse {{ $examsOpen ? 'show' : '' }}" id="examsMobile">
                <a href="{{ route('admin.exams.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.exams.index') ? 'active' : '' }}">لیست آزمون‌ها</a>
            </div>
        @endif

        <hr>

        <a href="#"
           class="sidebar-link"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span>خروج</span>
        </a>
    </div>
</div>

<!-- DESKTOP SIDEBAR -->
<div class="sidebar d-none d-lg-block">
    <div class="sidebar-title">پنل ادمین</div>

    <a href="{{ route($dashboardRoute) }}"
       class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span>داشبورد</span>
    </a>

    <a href="#coursesDesktop" data-bs-toggle="collapse" class="sidebar-link {{ $coursesOpen ? 'active' : '' }}">
        <span>دوره‌ها</span>
        <span class="menu-arrow">⌄</span>
    </a>
    <div class="collapse {{ $coursesOpen ? 'show' : '' }}" id="coursesDesktop">
        <a href="{{ route('admin.courses.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.courses.index') ? 'active' : '' }}">لیست دوره‌ها</a>
    </div>

    <a href="#traineesDesktop" data-bs-toggle="collapse" class="sidebar-link {{ $traineesOpen ? 'active' : '' }}">
        <span>کارآموزان</span>
        <span class="menu-arrow">⌄</span>
    </a>
    <div class="collapse {{ $traineesOpen ? 'show' : '' }}" id="traineesDesktop">
        <a href="{{ route('admin.trainees.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.trainees.index') ? 'active' : '' }}">لیست کارآموزان</a>
        <a href="{{ route('admin.trainees.create') }}" class="sidebar-sublink {{ request()->routeIs('admin.trainees.create') ? 'active' : '' }}">ایجاد کارآموز</a>
    </div>

    <a href="#paymentsDesktop" data-bs-toggle="collapse" class="sidebar-link {{ $paymentsOpen ? 'active' : '' }}">
        <span>پرداخت‌ها</span>
        <span class="menu-arrow">⌄</span>
    </a>
    <div class="collapse {{ $paymentsOpen ? 'show' : '' }}" id="paymentsDesktop">
        <a href="{{ route('admin.payments.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.payments.index') ? 'active' : '' }}">لیست پرداخت‌ها</a>
        <a href="{{ route('admin.payments.create') }}" class="sidebar-sublink {{ request()->routeIs('admin.payments.create') ? 'active' : '' }}">ثبت پرداخت</a>
    </div>

    @if(Route::has('admin.exams.index'))
        <a href="#examsDesktop" data-bs-toggle="collapse" class="sidebar-link {{ $examsOpen ? 'active' : '' }}">
            <span>آزمون‌ها</span>
            <span class="menu-arrow">⌄</span>
        </a>
        <div class="collapse {{ $examsOpen ? 'show' : '' }}" id="examsDesktop">
            <a href="{{ route('admin.exams.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.exams.index') ? 'active' : '' }}">لیست آزمون‌ها</a>
        </div>
    @endif

    <hr class="border-secondary">

    <a href="#"
       class="sidebar-link"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span>خروج</span>
    </a>
</div>

<!-- MAIN CONTENT -->
<div class="content">
    <div class="header">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-dark d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                ☰
            </button>
            <h5 class="mb-0">@yield('page_title', 'داشبورد')</h5>
        </div>

        <div class="user-name">
            {{ auth()->user()->name ?? 'ادمین' }}
        </div>
    </div>

    <main>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <div class="footer">
        © {{ date('Y') }} - پنل ادمین
    </div>
</div>

<form id="logout-form" action="{{ route('superadmin.logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
