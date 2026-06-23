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

</style>

</head>

<body>


<div class="sidebar">

<h5 class="mb-4 text-white">پنل ادمین</h5>


<a href="{{ route('admin.dashboard') }}"
class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
داشبورد
</a>


<a href="{{ route('admin.courses.index') }}"
class="sidebar-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
دوره‌ها
</a>


<a href="{{ route('admin.trainees.index') }}"
class="sidebar-link {{ request()->routeIs('admin.trainees.*') ? 'active' : '' }}">
کارآموزان
</a>


<a href="{{ route('admin.payments.index') }}"
class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
پرداخت‌ها
</a>


</div>


<div class="content">


<div class="header">

<h5>@yield('page_title')</h5>

<div>

<span class="me-3">{{ auth()->user()->name ?? 'Admin' }}</span>

<a href="{{ route('superadmin.logout') }}"
onclick="event.preventDefault();document.getElementById('logout-form').submit();"
class="btn btn-sm btn-danger">
خروج
</a>

<form id="logout-form"
action="{{ route('superadmin.logout') }}"
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
