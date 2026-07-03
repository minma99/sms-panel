<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'پنل مدیریت')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: Tahoma, sans-serif;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #111827;
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
            background: #1f2937;
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
            background: #1f2937;
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
</head>

<body>
@php
    $user = auth()->user();

    $dashboardRoute = 'user.dashboard';

    if ($user && $user->is_superadmin) {
        $dashboardRoute = 'superadmin.dashboard';
    } elseif ($user && method_exists($user, 'hasRole') && $user->hasRole('admin')) {
        $dashboardRoute = 'admin.dashboard';
    }

    $coursesOpen = request()->routeIs('superadmin.courses.*');
    $traineesOpen = request()->routeIs('superadmin.trainees.*');
    $usersOpen = request()->routeIs('superadmin.users.*');
    $paymentsOpen = request()->routeIs('superadmin.payments.*');
    $examsOpen = request()->routeIs('superadmin.exams.*');
    $superAdminOpen = request()->routeIs('superadmin.settings');
@endphp

<!-- MOBILE MENU -->
<div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
        <h5 class="mb-0">پنل مدیریت</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-3">
        <a href="{{ route($dashboardRoute) }}"
           class="sidebar-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
            <span>داشبورد</span>
        </a>

        <a href="#coursesMobile"
           data-bs-toggle="collapse"
           class="sidebar-link {{ $coursesOpen ? 'active' : '' }}">
            <span>دوره‌ها</span>
            <span class="menu-arrow">⌄</span>
        </a>

        <div class="collapse {{ $coursesOpen ? 'show' : '' }}" id="coursesMobile">
            <a href="{{ route('superadmin.courses.index') }}"
               class="sidebar-sublink {{ request()->routeIs('superadmin.courses.index') ? 'active' : '' }}">
                لیست دوره‌ها
            </a>

            <a href="{{ route('superadmin.courses.create') }}"
               class="sidebar-sublink {{ request()->routeIs('superadmin.courses.create') ? 'active' : '' }}">
                ایجاد دوره
            </a>
        </div>

        <a href="#traineesMobile"
           data-bs-toggle="collapse"
           class="sidebar-link {{ $traineesOpen ? 'active' : '' }}">
            <span>کارآموزان</span>
            <span class="menu-arrow">⌄</span>
        </a>

        <div class="collapse {{ $traineesOpen ? 'show' : '' }}" id="traineesMobile">
            <a href="{{ route('superadmin.trainees.index') }}"
               class="sidebar-sublink {{ request()->routeIs('superadmin.trainees.index') ? 'active' : '' }}">
                لیست کارآموزان
            </a>

            <a href="{{ route('superadmin.trainees.create') }}"
               class="sidebar-sublink {{ request()->routeIs('superadmin.trainees.create') ? 'active' : '' }}">
                ایجاد کارآموز
            </a>
        </div>

        <a href="#usersMobile"
           data-bs-toggle="collapse"
           class="sidebar-link {{ $usersOpen ? 'active' : '' }}">
            <span>کاربران</span>
            <span class="menu-arrow">⌄</span>
        </a>

        <div class="collapse {{ $usersOpen ? 'show' : '' }}" id="usersMobile">
            <a href="{{ route('superadmin.users.index') }}"
               class="sidebar-sublink {{ request()->routeIs('superadmin.users.index') ? 'active' : '' }}">
                لیست کاربران
            </a>

            <a href="{{ route('superadmin.users.create') }}"
               class="sidebar-sublink {{ request()->routeIs('superadmin.users.create') ? 'active' : '' }}">
                ایجاد کاربر
            </a>
        </div>

        <a href="#paymentsMobile"
           data-bs-toggle="collapse"
           class="sidebar-link {{ $paymentsOpen ? 'active' : '' }}">
            <span>پرداخت‌ها</span>
            <span class="menu-arrow">⌄</span>
        </a>

        <div class="collapse {{ $paymentsOpen ? 'show' : '' }}" id="paymentsMobile">
            <a href="{{ route('superadmin.payments.index') }}"
               class="sidebar-sublink {{ request()->routeIs('superadmin.payments.index') ? 'active' : '' }}">
                لیست پرداخت‌ها
            </a>

            <a href="{{ route('superadmin.payments.create') }}"
               class="sidebar-sublink {{ request()->routeIs('superadmin.payments.create') ? 'active' : '' }}">
                ثبت پرداخت
            </a>
        </div>

        <a href="#examsMobile"
           data-bs-toggle="collapse"
           class="sidebar-link {{ $examsOpen ? 'active' : '' }}">
            <span>آزمون‌ها</span>
            <span class="menu-arrow">⌄</span>
        </a>

        <div class="collapse {{ $examsOpen ? 'show' : '' }}" id="examsMobile">
            <a href="{{ route('superadmin.exams.index') }}"
               class="sidebar-sublink {{ request()->routeIs('superadmin.exams.index') ? 'active' : '' }}">
                لیست آزمون‌ها
            </a>

            <a href="{{ route('superadmin.exams.create') }}"
               class="sidebar-sublink {{ request()->routeIs('superadmin.exams.create') ? 'active' : '' }}">
                ثبت آزمون
            </a>
        </div>

        @if(auth()->check() && auth()->user()->is_superadmin)
            <hr>

            <a href="{{ route('superadmin.settings') }}"
               class="sidebar-link {{ request()->routeIs('superadmin.settings') ? 'active' : '' }}">
                <span>تنظیمات پیامک</span>
            </a>
        @endif
    </div>
</div>

<!-- 