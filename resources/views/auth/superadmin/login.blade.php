<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود سوپر ادمین | بوت استرپ</title>

    <!-- Bootstrap 5 RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    <style>
        /* استفاده از فونت سیستم برای اطمینان از سرعت لود */
        body {
            font-family: Tahoma, Arial, sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background: #fff;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 10px;
        }
        input {
            text-align: left; /* فیلدها چپ‌چین برای اعداد و پسورد */
            direction: ltr;
        }
        label {
            display: block;
            width: 100%;
            text-align: right;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h3 class="text-center mb-4">ورود سوپر ادمین</h3>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('superadmin.login.submit') }}">
            @csrf

            <div class="mb-3">
                <label>شماره موبایل</label>
                <input type="text" name="phone" value="{{ old('phone') }}" 
                       class="form-control" placeholder="09120000000" required>
            </div>

            <div class="mb-4">
                <label>رمز عبور</label>
                <input type="password" name="password" 
                       class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold">
                ورود به سیستم
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="/" class="text-muted text-decoration-none small">← بازگشت به سایت</a>
        </div>
    </div>

    <!-- Bootstrap JS (اختیاری) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
