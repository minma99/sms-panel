<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<title>@yield('title')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

<style>
body{background:#f5f7fb;font-family:tahoma}

.sidebar{
width:250px;
min-height:100vh;
background:#111827;
color:white;
position:fixed;
right:0;
top:0;
padding:20px;
overflow-y:auto;
}

.sidebar-link{
display:block;
color:#cbd5e1;
text-decoration:none;
padding:10px 15px;
border-radius:8px;
margin-bottom:5px;
}

.sidebar-link:hover{background:#1f2937;color:white}

.sidebar-link.active{background:#3b82f6;color:white}

.sidebar-sublink{
display:block;
color:#cbd5e1;
padding:8px 15px;
padding-right:30px;
text-decoration:none;
font-size:14px;
border-radius:8px;
margin-bottom:4px;
}

.sidebar-sublink:hover{background:#1f2937;color:white}

.sidebar-sublink.active{color:#fff;font-weight:bold}

.content{
margin-right:250px;
padding:20px;
min-height:100vh;
display:flex;
flex-direction:column;
}

.header{
background:white;
padding:15px 20px;
border-radius:10px;
box-shadow:0 2px 6px rgba(0,0,0,.05);
margin-bottom:20px;
display:flex;
justify-content:space-between;
align-items:center;
}

.footer{
margin-top:auto;
text-align:center;
padding:15px;
font-size:14px;
color:#888;
}

@media (max-width:992px){
.sidebar{display:none}
.content{margin-right:0}
}
</style>
</head>

<body>

@php
$coursesOpen = request()->routeIs('admin.courses.*');
$traineesOpen = request()->routeIs('admin.trainees.*');
$paymentsOpen = request()->routeIs('admin.payments.*');
$examsOpen = request()->routeIs('admin.exams.*');
@endphp

<!-- MOBILE MENU -->
<div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileSidebar">
<div class="offcanvas-header">
<h5>پنل ادمین</h5>
<button class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>

<div class="offcanvas-body p-3">

<a href="{{ route('admin.dashboard') }}" class="sidebar-link">داشبورد</a>

<a href="#coursesMobile" data-bs-toggle="collapse"
class="sidebar-link {{ $coursesOpen ? 'active' : '' }}">دوره‌ها ⌄</a>
<div class="collapse {{ $coursesOpen ? 'show' : '' }}" id="coursesMobile">
<a href="{{ route('admin.courses.index') }}" class="sidebar-sublink">لیست دوره‌ها</a>
<a href="{{ route('admin.courses.create') }}" class="sidebar-sublink">ایجاد دوره</a>
</div>

<a href="#traineesMobile" data-bs-toggle="collapse"
class="sidebar-link {{ $traineesOpen ? 'active' : '' }}">کارآموزان ⌄</a>
<div class="collapse {{ $traineesOpen ? 'show' : '' }}" id="traineesMobile">
<a href="{{ route('admin.trainees.index') }}" class="sidebar-sublink">لیست کارآموزان</a>
<a href="{{ route('admin.trainees.create') }}" class="sidebar-sublink">ایجاد کارآموز</a>
</div>

<a href="#paymentsMobile" data-bs-toggle="collapse"
class="sidebar-link {{ $paymentsOpen ? 'active' : '' }}">پرداخت‌ها ⌄</a>
<div class="collapse {{ $paymentsOpen ? 'show' : '' }}" id="paymentsMobile">
<a href="{{ route('admin.payments.index') }}" class="sidebar-sublink">لیست پرداخت‌ها</a>
<a href="{{ route('admin.payments.create') }}" class="sidebar-sublink">ثبت پرداخت</a>
</div>

<!-- EXAMS (MOBILE) -->
<a href="#examsMobile" data-bs-toggle="collapse"
class="sidebar-link {{ $examsOpen ? 'active' : '' }}">آزمون‌ها ⌄</a>

<div class="collapse {{ $examsOpen ? 'show' : '' }}" id="examsMobile">
<a href="{{ route('admin.exams.index') }}" class="sidebar-sublink">لیست آزمون‌ها</a>
<a href="{{ route('admin.exams.create') }}" class="sidebar-sublink">ثبت آزمون</a>
</div>

</div>
</div>

<!-- DESKTOP SIDEBAR -->
<div class="sidebar d-none d-lg-block">

<h5 class="text-white mb-4">پنل ادمین</h5>

<a href="{{ route('admin.dashboard') }}"
class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
داشبورد
</a>

<!-- COURSES -->
<a href="#coursesDesktop" data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between align-items-center {{ $coursesOpen ? 'active' : '' }}">
<span>دوره‌ها</span>
<span>⌄</span>
</a>

<div class="collapse {{ $coursesOpen ? 'show' : '' }}" id="coursesDesktop">
<a href="{{ route('admin.courses.index') }}" class="sidebar-sublink">لیست دوره‌ها</a>
<a href="{{ route('admin.courses.create') }}" class="sidebar-sublink">ایجاد دوره</a>
</div>

<!-- TRAINEES -->
<a href="#traineesDesktop" data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between align-items-center {{ $traineesOpen ? 'active' : '' }}">
<span>کارآموزان</span>
<span>⌄</span>
</a>

<div class="collapse {{ $traineesOpen ? 'show' : '' }}" id="traineesDesktop">
<a href="{{ route('admin.trainees.index') }}" class="sidebar-sublink">لیست کارآموزان</a>
<a href="{{ route('admin.trainees.create') }}" class="sidebar-sublink">ایجاد کارآموز</a>
</div>

<!-- PAYMENTS -->
<a href="#paymentsDesktop" data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between align-items-center {{ $paymentsOpen ? 'active' : '' }}">
<span>پرداخت‌ها</span>
<span>⌄</span>
</a>

<div class="collapse {{ $paymentsOpen ? 'show' : '' }}" id="paymentsDesktop">
<a href="{{ route('admin.payments.index') }}" class="sidebar-sublink">لیست پرداخت‌ها</a>
<a href="{{ route('admin.payments.create') }}" class="sidebar-sublink">ثبت پرداخت</a>
</div>

<!-- EXAMS (DESKTOP) -->
<a href="#examsDesktop" data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between align-items-center {{ $examsOpen ? 'active' : '' }}">
<span>آزمون‌ها</span>
<span>⌄</span>
</a>

<div class="collapse {{ $examsOpen ? 'show' : '' }}" id="examsDesktop">
<a href="{{ route('admin.exams.index') }}" class="sidebar-sublink">لیست آزمون‌ها</a>
<a href="{{ route('admin.exams.create') }}" class="sidebar-sublink">ثبت آزمون</a>
</div>

</div>

<!-- CONTENT AREA -->
<div class="content">

<div class="header">

<div class="d-flex align-items-center gap-2">
<button class="btn btn-outline-secondary d-lg-none"
data-bs-toggle="offcanvas"
data-bs-target="#mobileSidebar">☰</button>

<h5 class="mb-0">@yield('page_title')</h5>
</div>

<div>

<span class="me-3">{{ auth()->user()->name ?? 'Admin' }}</span>

<a href="#"
onclick="event.preventDefault();document.getElementById('logout-form').submit();"
class="btn btn-sm btn-danger">
خروج
</a>

<form id="logout-form"
action="{{ route('admin.logout') }}"
method="POST"
class="d-none">
@csrf
</form>

</div>

</div>

<div class="flex-grow-1">
@yield('content')
</div>

<div class="footer">
© {{ date('Y') }} Admin Panel
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
