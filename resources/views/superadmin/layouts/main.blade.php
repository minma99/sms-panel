<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title','Admin Panel')</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<!-- overlay mobile -->
<div id="overlay" class="fixed inset-0 bg-black/40 hidden md:hidden"></div>

<!-- sidebar -->
<aside id="sidebar"
class="fixed md:static z-30 w-64 bg-gray-900 text-white h-full transform -translate-x-full md:translate-x-0 transition-transform duration-300">

<div class="p-6 text-xl font-bold border-b border-gray-700">
SMS Panel
</div>

<nav class="p-4 space-y-2">

<a href="{{ route('super_admin.dashboard') }}"
class="block px-4 py-2 rounded hover:bg-gray-700">
Dashboard
</a>

<a href="{{ route('courses.index') }}"
class="block px-4 py-2 rounded hover:bg-gray-700">
Courses
</a>

<a href="{{ route('trainees.index') }}"
class="block px-4 py-2 rounded hover:bg-gray-700">
Trainees
</a>

<a href="{{ route('users.index') }}"
class="block px-4 py-2 rounded hover:bg-gray-700">
Users
</a>

</nav>

</aside>


<!-- main -->
<div class="flex-1 flex flex-col">

<!-- navbar -->
<header class="bg-white shadow flex items-center justify-between px-6 py-4">

<div class="flex items-center gap-4">

<button id="menuBtn" class="md:hidden text-xl">
☰
</button>

<h1 class="text-lg font-semibold text-gray-700">
@yield('page_title','Dashboard')
</h1>

</div>

<div class="text-gray-600">
{{ auth()->user()->name ?? 'Admin' }}
</div>

</header>


<!-- page content -->
<main class="p-6 space-y-6 overflow-y-auto">

@yield('content')

</main>

</div>

</div>


<script>

const sidebar = document.getElementById('sidebar')
const overlay = document.getElementById('overlay')
const menuBtn = document.getElementById('menuBtn')

menuBtn.addEventListener('click', () => {

sidebar.classList.toggle('-translate-x-full')
overlay.classList.toggle('hidden')

})

overlay.addEventListener('click', () => {

sidebar.classList.add('-translate-x-full')
overlay.classList.add('hidden')

})

</script>

</body>
</html>