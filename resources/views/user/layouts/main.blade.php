<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'آموزشگاه تفکر نو')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700;800&display=swap');

        :root {
            --brand-green: #2ecc71;
            --brand-green-dark: #27ae60;
            --brand-yellow: #f4c542;
            --brand-navy: #1e293b;
            --brand-light: #f8fafc;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Vazirmatn', sans-serif;
            background: #f8fafc;
            color: var(--brand-navy);
            min-height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        a {
            text-decoration: none;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .navbar-brand-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            color: var(--brand-navy);
            font-size: 1.1rem;
        }

        .navbar-brand-custom img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .nav-link-custom {
            color: var(--brand-navy);
            font-weight: 600;
            transition: 0.25s ease;
            position: relative;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: var(--brand-green-dark);
        }

        .nav-link-custom::after {
            content: "";
            position: absolute;
            right: 0;
            bottom: -6px;
            width: 0;
            height: 2px;
            background: var(--brand-green);
            transition: 0.25s ease;
        }

        .nav-link-custom:hover::after,
        .nav-link-custom.active::after {
            width: 100%;
        }

        .header-btn {
            background: linear-gradient(135deg, var(--brand-green), var(--brand-green-dark));
            color: #fff;
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 700;
            transition: 0.25s ease;
            box-shadow: 0 12px 24px rgba(46, 204, 113, 0.18);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .header-btn:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .page-content {
            flex: 1;
            min-height: calc(100vh - 190px);
        }

        .site-footer {
            background:
                linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0)),
                var(--brand-navy);
            color: #cbd5e1;
            margin-top: 48px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .footer-title {
            color: #fff;
            font-weight: 800;
            margin-bottom: 16px;
            font-size: 1.05rem;
        }

        .footer-text {
            line-height: 2;
            color: #cbd5e1;
            margin-bottom: 0;
        }

        .footer-link {
            color: #cbd5e1;
            display: block;
            margin-bottom: 10px;
            transition: 0.25s ease;
        }

        .footer-link:hover {
            color: #fff;
            transform: translateX(-2px);
        }

        .footer-contact {
            display: grid;
            gap: 12px;
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.9;
            color: #cbd5e1;
        }

        .footer-contact-item i {
            color: var(--brand-green);
            margin-top: 4px;
            width: 18px;
            text-align: center;
            flex: 0 0 18px;
        }

        .footer-contact-item strong {
            color: #fff;
            margin-left: 6px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: 20px;
            padding-top: 16px;
            color: #94a3b8;
            font-size: 0.95rem;
        }

        .section-card {
            border: 0;
            border-radius: 24px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        }

        @media (max-width: 991px) {
            .navbar-collapse {
                margin-top: 12px;
                background: #fff;
                padding: 16px;
                border-radius: 16px;
                border: 1px solid var(--border-color);
            }

            .header-btn {
                margin-top: 10px;
                justify-content: center;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <header class="site-header">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container">
                <a class="navbar-brand navbar-brand-custom" href="{{ route('login') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="لوگو">
                    <span>آموزشگاه تفکر نو</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-3">
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('login') ? 'active' : '' }}"
                               href="{{ route('login') }}">
                                ورود
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('about') ? 'active' : '' }}"
                               href="{{ route('about') }}">
                                درباره ما
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('contact') ? 'active' : '' }}"
                               href="{{ route('contact') }}">
                                تماس با ما
                            </a>
                        </li>
                    </ul>

                    <a href="{{ route('contact') }}" class="header-btn">
                        <i class="fas fa-phone-alt"></i>
                        ارتباط با ما
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="page-content">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="footer-title">آموزشگاه تفکر نو</h5>
                    <p class="footer-text">
                        آموزشگاه تفکر نو با هدف آموزش مهارت‌های تخصصی، فناوری و مسیر رشد کارآموزان
                        ایجاد شده و تلاش می‌کند تجربه‌ای حرفه‌ای و مطمئن برای کاربران فراهم کند.
                    </p>
                </div>

                <div class="col-lg-3">
                    <h5 class="footer-title">دسترسی سریع</h5>
                    <a href="{{ route('login') }}" class="footer-link">ورود</a>
                    <a href="{{ route('about') }}" class="footer-link">درباره ما</a>
                    <a href="{{ route('contact') }}" class="footer-link">تماس با ما</a>
                </div>

                <div class="col-lg-5">
                    <h5 class="footer-title">اطلاعات تماس</h5>

                    <div class="footer-contact">
                        <div class="footer-contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>آدرس:</strong>
                                خیابان یک‌شه‌وه، کوچه لاچین 3
                            </div>
                        </div>

                        <div class="footer-contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong>تلفن ثابت:</strong>
                                04446284124
                            </div>
                        </div>

                        <div class="footer-contact-item">
                            <i class="fas fa-mobile-screen-button"></i>
                            <div>
                                <strong>موبایل:</strong>
                                09109915180
                            </div>
                        </div>

                        <div class="footer-contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>ایمیل:</strong>
                                <a href="mailto:mina.mamrasouli1999@gmail.com" class="footer-link d-inline">
                                    mina.mamrasouli1999@gmail.com
                                </a>
                            </div>
                        </div>

                        <div class="footer-contact-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>ساعات پاسخگویی:</strong>
                                شنبه تا پنجشنبه، 9 صبح تا 6 عصر
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom text-center">
                © {{ date('Y') }} تمامی حقوق برای آموزشگاه تفکر نو محفوظ است.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
