<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<title>@yield('title')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

<style>

body{
background:#f5f7fb;
font-family:tahoma;
}

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

.sidebar-link:hover{
background:#1f2937;
color:white;
}

.sidebar-link.active{
background:#3b82f6;
color:white;
}

.sidebar-sublink{
display:block;
color:#cbd5e1;
padding:8px 15px;
padding-right:30px;
text-decoration:none;
font-size:14px;
}

.sidebar-sublink:hover{
background:#1f2937;
color:white;
}

.sidebar-sublink.active{
color:#fff;
font-weight:bold;
}

.arrow{
transition:.3s;
}

.arrow.rotate{
transform:rotate(180deg);
}

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

/* mobile */

@media (max-width:992px){

.sidebar{
display:none;
}

.content{
margin-right:0;
}

}

</style>
</head>

<body>

@php
$coursesOpen = request()->routeIs('courses.*');
$traineesOpen = request()->routeIs('trainees.*');
$usersOpen = request()->routeIs('users.*');
$paymentsOpen = request()->routeIs('payments.*');
@endphp


<!-- MOBILE MENU -->

<div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileSidebar">

<div class="offcanvas-header">
<h5>پنل مدیریت</h5>
<button class="btn-close" data-bs-dismiss="offcanvas"></button>
</div>

<div class="offcanvas-body p-3">

<h5 class="mb-4">پنل مدیریت</h5>

<a href="{{ route('dashboard') }}"
class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
داشبورد
</a>

<!-- Courses -->

<a href="#coursesMenuMobile"
data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between">

<span>دوره‌ها</span>
<span>⌄</span>

</a>

<div class="collapse {{ $coursesOpen ? 'show' : '' }}" id="coursesMenuMobile">

<a href="{{ route('courses.index') }}" class="sidebar-sublink">
لیست دوره‌ها
</a>

<a href="{{ route('courses.create') }}" class="sidebar-sublink">
ایجاد دوره
</a>

</div>


<!-- Trainees -->

<a href="#traineesMenuMobile"
data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between">

<span>کارآموزان</span>
<span>⌄</span>

</a>

<div class="collapse {{ $traineesOpen ? 'show' : '' }}" id="traineesMenuMobile">

<a href="{{ route('trainees.index') }}" class="sidebar-sublink">
لیست کارآموزان
</a>

<a href="{{ route('trainees.create') }}" class="sidebar-sublink">
ایجاد کارآموز
</a>

</div>


<!-- Users -->

<a href="#usersMenuMobile"
data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between">

<span>کاربران</span>
<span>⌄</span>

</a>

<div class="collapse {{ $usersOpen ? 'show' : '' }}" id="usersMenuMobile">

<a href="{{ route('users.index') }}" class="sidebar-sublink">
لیست کاربران
</a>

<a href="{{ route('users.create') }}" class="sidebar-sublink">
ایجاد کاربر
</a>

</div>


<!-- Payments -->

<a href="#paymentsMenuMobile"
data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between">

<span>پرداخت‌ها</span>
<span>⌄</span>

</a>

<div class="collapse {{ $paymentsOpen ? 'show' : '' }}" id="paymentsMenuMobile">

<a href="{{ route('payments.index') }}" class="sidebar-sublink">
لیست پرداخت‌ها
</a>

<a href="{{ route('payments.create') }}" class="sidebar-sublink">
ثبت پرداخت
</a>

</div>

</div>
</div>


<!-- DESKTOP SIDEBAR -->

<div class="sidebar d-none d-lg-block">

<h5 class="text-white mb-4">پنل مدیریت</h5>

<a href="{{ route('dashboard') }}"
class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
داشبورد
</a>


<!-- Courses -->

<a href="#coursesMenuDesktop"
data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between align-items-center {{ $coursesOpen ? 'active' : '' }}">

<span>دوره‌ها</span>
<span class="arrow {{ $coursesOpen ? 'rotate' : '' }}">⌄</span>

</a>

<div class="collapse {{ $coursesOpen ? 'show' : '' }}" id="coursesMenuDesktop">

<a href="{{ route('courses.index') }}"
class="sidebar-sublink {{ request()->routeIs('courses.index') ? 'active' : '' }}">
لیست دوره‌ها
</a>

<a href="{{ route('courses.create') }}"
class="sidebar-sublink {{ request()->routeIs('courses.create') ? 'active' : '' }}">
ایجاد دوره
</a>

</div>


<!-- Trainees -->

<a href="#traineesMenuDesktop"
data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between align-items-center {{ $traineesOpen ? 'active' : '' }}">

<span>کارآموزان</span>
<span class="arrow {{ $traineesOpen ? 'rotate' : '' }}">⌄</span>

</a>

<div class="collapse {{ $traineesOpen ? 'show' : '' }}" id="traineesMenuDesktop">

<a href="{{ route('trainees.index') }}" class="sidebar-sublink">
لیست کارآموزان
</a>

<a href="{{ route('trainees.create') }}" class="sidebar-sublink">
ایجاد کارآموز
</a>

</div>


<!-- Users -->

<a href="#usersMenuDesktop"
data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between align-items-center {{ $usersOpen ? 'active' : '' }}">

<span>کاربران</span>
<span class="arrow {{ $usersOpen ? 'rotate' : '' }}">⌄</span>

</a>

<div class="collapse {{ $usersOpen ? 'show' : '' }}" id="usersMenuDesktop">

<a href="{{ route('users.index') }}" class="sidebar-sublink">
لیست کاربران
</a>

<a href="{{ route('users.create') }}" class="sidebar-sublink">
ایجاد کاربر
</a>

</div>


<!-- Payments -->

<a href="#paymentsMenuDesktop"
data-bs-toggle="collapse"
class="sidebar-link d-flex justify-content-between align-items-center {{ $paymentsOpen ? 'active' : '' }}">

<span>پرداخت‌ها</span>
<span class="arrow {{ $paymentsOpen ? 'rotate' : '' }}">⌄</span>

</a>

<div class="collapse {{ $paymentsOpen ? 'show' : '' }}" id="paymentsMenuDesktop">

<a href="{{ route('payments.index') }}" class="sidebar-sublink">
لیست پرداخت‌ها
</a>

<a href="{{ route('payments.create') }}" class="sidebar-sublink">
ثبت پرداخت
</a>

</div>

</div>


<div class="content">

<div class="header">

<div class="d-flex align-items-center gap-2">

<button class="btn btn-outline-secondary d-lg-none"
data-bs-toggle="offcanvas"
data-bs-target="#mobileSidebar">
☰
</button>

<h5 class="mb-0">@yield('page_title')</h5>

</div>

<div>

<span class="me-3">{{ auth()->user()->name ?? 'Admin' }}</span>

<a href="{{ route('superadmin.logout') }}"
onclick="event.preventDefault();document.getElementById('logout-form').submit();"
class="btn btn-sm btn-danger">
خروج
</a>

<form id="logout-form" action="{{ route('superadmin.logout') }}" method="POST" class="d-none">
@csrf
</form>

</div>

</div>


<div class="flex-grow-1">
@yield('content')
</div>


<div class="footer">
© {{ date('Y') }} Super Admin Panel
</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
