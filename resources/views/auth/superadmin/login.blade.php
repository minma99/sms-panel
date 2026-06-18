<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SuperAdmin Login</title>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

<div class="bg-white p-8 rounded-xl shadow w-full max-w-md">

<h1 class="text-2xl font-bold text-center mb-6">
SuperAdmin Login
</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
{{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('superadmin.login.submit') }}">
@csrf

<div class="mb-4">
<label class="block mb-1">Phone</label>
<input type="text" name="phone" value="{{ old('phone') }}"
class="w-full border rounded px-3 py-2">
</div>

<div class="mb-6">
<label class="block mb-1">Password</label>
<input type="password" name="password"
class="w-full border rounded px-3 py-2">
</div>

<button class="w-full bg-blue-600 text-white py-2 rounded">
Login
</button>

</form>

</div>

</body>
</html>
