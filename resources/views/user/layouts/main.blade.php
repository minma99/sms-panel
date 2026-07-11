<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'پنل کاربر')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background: #f8fafc;
            font-family: Tahoma, sans-serif;
        }

        .topbar {
            background: #0f172a;
            color: #fff;
            padding: 14px 0;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        }

        .brand-title {
            font-weight: 700;
            font-size: 18px;
            margin: 0;
        }

        .panel-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .footer {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            padding: 20px 0;
            margin-top: 40px;
        }
    </style>

    @stack('styles')
</head>
<body>
    <header class="topbar">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="brand-title mb-0">پنل کاربر</h1>

            <div class="d-flex align-items-center gap-3">
                <span>{{ auth()->user()->name ?? auth()->guard('trainee')->user()->full_name ?? 'کاربر' }}</span>

                @if(Route::has('logout'))
                    <a href="#"
                       class="btn btn-sm btn-light"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        خروج
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main class="py-4">
        <div class="container">
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

            <div class="panel-card card">
                <div class="card-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <div class="footer">
        © {{ date('Y') }} - پنل کاربر
    </div>

    @if(Route::has('logout'))
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
