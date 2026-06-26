<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ورود به پنل | آموزشگاه تفکر نو</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;500;800&display=swap');

        :root {
            --brand-green: #2ecc71;
            --brand-green-dark: #27ae60;
            --brand-yellow: #f4c542;
            --brand-navy: #1e293b;
            --glass: rgba(255, 255, 255, 0.65);
            --glass-border: rgba(255, 255, 255, 0.8);
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            font-family: 'Vazirmatn', sans-serif;
            background: #f0f4f8;
            overflow-x: hidden;
            color: var(--brand-navy);
        }

        body {
            min-height: 100dvh;
        }

        .page-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100dvh;
            background:
                radial-gradient(circle at 10% 20%, rgba(46, 204, 113, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(244, 197, 66, 0.1) 0%, transparent 40%);
            padding: 20px;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
            opacity: 0.5;
            animation: move 15s infinite alternate;
        }

        .blob-1 {
            width: 300px;
            height: 300px;
            background: var(--brand-green);
            top: -100px;
            right: 10%;
        }

        .blob-2 {
            width: 250px;
            height: 250px;
            background: var(--brand-yellow);
            bottom: -50px;
            left: 10%;
            animation-delay: -5s;
        }

        @keyframes move {
            from { transform: translate(0, 0); }
            to { transform: translate(50px, 80px); }
        }

        .main-container {
            position: relative;
            z-index: 1;
            display: flex;
            width: 100%;
            max-width: 1100px;
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-height: min(650px, calc(100dvh - 40px));
        }

        .visual-section {
            flex: 1.2;
            background: rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .vector-box {
            width: 100%;
            max-width: 450px;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .info-text {
            text-align: center;
            margin-top: 30px;
        }

        .info-text h1 {
            font-weight: 800;
            font-size: 2.2rem;
            color: var(--brand-navy);
            margin-bottom: 10px;
        }

        .info-text p {
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .form-section {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
            overflow-y: auto;
        }

        .form-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo-box {
            text-align: center;
        }

        .logo-box img {
            width: 78px;
            height: auto;
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1));
        }

        .login-title {
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #94a3b8;
            margin-bottom: 35px;
        }

        .form-control-modern {
            background: #f8fafc !important;
            border: 2px solid #e2e8f0 !important;
            border-radius: 16px !important;
            padding: 14px 20px !important;
            font-size: 1.1rem;
            transition: 0.3s;
        }

        .form-control-modern:focus {
            border-color: var(--brand-green) !important;
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.15) !important;
        }

        .btn-brand {
            background: var(--brand-green);
            border: none;
            border-radius: 16px;
            padding: 16px;
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
            width: 100%;
            box-shadow: 0 10px 20px rgba(46, 204, 113, 0.25);
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-brand:hover {
            background: var(--brand-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(46, 204, 113, 0.35);
        }

        .otp-wrapper {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .otp-input {
            width: 55px;
            height: 65px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            text-align: center;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--brand-navy);
            transition: 0.3s;
        }

        .otp-input:focus {
            border-color: var(--brand-yellow);
            outline: none;
            background: white;
        }

        .badge-ai {
            position: absolute;
            top: 20%;
            right: 15%;
            background: var(--brand-yellow);
            color: white;
            padding: 8px 15px;
            border-radius: 12px;
            font-weight: 800;
            box-shadow: 0 10px 20px rgba(244, 197, 66, 0.3);
            animation: float 5s ease-in-out infinite reverse;
        }

        @media (max-width: 992px) {
            .visual-section {
                display: none;
            }

            .main-container {
                max-width: 500px;
                min-height: auto;
            }

            .form-section {
                padding: 35px 24px;
                overflow-y: visible;
            }
        }

        @media (max-width: 576px) {
            .page-wrapper {
                padding: 12px;
            }

            .main-container {
                border-radius: 24px;
                min-height: auto;
            }

            .form-section {
                padding: 28px 18px;
            }

            .logo-box img {
                width: 60px;
            }

            .login-title {
                font-size: 1.5rem;
            }

            .login-subtitle {
                font-size: 0.95rem;
                margin-bottom: 25px;
            }

            .form-control-modern {
                font-size: 1rem;
                padding: 12px 16px !important;
                border-radius: 14px !important;
            }

            .btn-brand {
                font-size: 1rem;
                padding: 14px;
                border-radius: 14px;
            }

            .otp-wrapper {
                gap: 8px;
            }

            .otp-input {
                width: 46px;
                height: 56px;
                font-size: 1.3rem;
                border-radius: 12px;
            }

            .blob-1 {
                width: 180px;
                height: 180px;
                top: -50px;
            }

            .blob-2 {
                width: 160px;
                height: 160px;
                bottom: -40px;
            }
        }

        @media (max-width: 380px) {
            .form-section {
                padding: 22px 14px;
            }

            .login-title {
                font-size: 1.3rem;
            }

            .otp-input {
                width: 40px;
                height: 50px;
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>

    <div class="page-wrapper">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>

        <div class="main-container">
            <!-- سمت راست: وکتور و متن -->
            <div class="visual-section">
                <div class="badge-ai">AI Learning</div>
                <div class="vector-box">
                    <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#2ecc71;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#27ae60;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <circle cx="250" cy="250" r="200" fill="white" fill-opacity="0.5" />
                        <rect x="100" y="100" width="300" height="200" rx="20" fill="#1e293b" />
                        <rect x="115" y="115" width="270" height="150" rx="10" fill="#f8fafc" />
                        <path d="M250 300 Q250 200 350 200 L370 400 L130 400 L150 200 Q250 200 250 300" fill="url(#grad)" />
                        <circle cx="250" cy="170" r="40" fill="#334155" />
                        <circle cx="150" cy="150" r="15" fill="#f4c542" opacity="0.8" />
                        <circle cx="350" cy="180" r="12" fill="#3498db" opacity="0.8" />
                        <path d="M120 280 L180 280" stroke="#f4c542" stroke-width="8" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="info-text">
                    <h1>آموزشگاه تفکر نو</h1>
                    <p>ورود به دنیای هوش مصنوعی و تخصص</p>
                </div>
            </div>

            <!-- سمت چپ: فرم ورود -->
            <div class="form-section">
                <div class="form-header">
                    <div class="logo-box">
                        <img src="{{ asset('images/logo.png') }}" alt="تفکر نو">
                    </div>
                </div>

                <div id="step-1">
                    <h2 class="login-title">خوش آمدید</h2>
                    <p class="login-subtitle">شماره موبایل خود را وارد کنید</p>

                    <div class="mb-4">
                        <input type="text" id="mobile" class="form-control form-control-modern" placeholder="0912XXXXXXX" maxlength="11">
                    </div>

                    <button id="btn-send" class="btn-brand">
                        ارسال کد تایید
                        <i class="fas fa-arrow-left ms-2"></i>
                    </button>
                </div>

                <div id="step-2" style="display:none;">
                    <h2 class="login-title">تایید هویت</h2>
                    <p class="login-subtitle">کد ۴ رقمی ارسال شده را وارد کنید</p>

                    <div class="otp-wrapper" dir="ltr">
                        <input type="text" maxlength="1" class="otp-input">
                        <input type="text" maxlength="1" class="otp-input">
                        <input type="text" maxlength="1" class="otp-input">
                        <input type="text" maxlength="1" class="otp-input">
                    </div>

                    <button id="btn-verify" class="btn-brand" style="background: var(--brand-navy);">
                        ورود به پنل کاربری
                    </button>

                    <div class="text-center mt-4">
                        <p class="small text-muted" id="timer-box">
                            ارسال مجدد کد تا
                            <span id="timer" class="fw-bold text-success">60</span>
                            ثانیه دیگر
                        </p>
                    </div>
                </div>

                <div id="alert-msg" class="mt-3 text-center small"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.otp-input').on('keyup', function(e) {
                if (this.value.length === 1) $(this).next('.otp-input').focus();
                if (e.keyCode === 8) $(this).prev('.otp-input').focus();
            });

            $('#btn-send').click(function() {
                let mobile = $('#mobile').val();

                if (mobile.length < 11) {
                    $('#alert-msg').text('شماره موبایل اشتباه است').css('color', '#e74c3c');
                    return;
                }

                $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.post('/send-otp', {
                    mobile: mobile,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }).done(function() {
                    $('#step-1').hide();
                    $('#step-2').fadeIn();
                    startTimer();
                }).fail(function() {
                    alert('خطا در ارسال کد');
                    $('#btn-send').prop('disabled', false).html('ارسال کد تایید <i class="fas fa-arrow-left ms-2"></i>');
                });
            });

            $('#btn-verify').click(function() {
                let otp = "";
                $('.otp-input').each(function() {
                    otp += $(this).val();
                });

                $.post('/verify-otp', {
                    mobile: $('#mobile').val(),
                    code: otp,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }).done(function(res) {
                    if (res.status === 'success') {
                        window.location.href = res.redirect;
                    } else {
                        $('#alert-msg').text(res.message).css('color', '#e74c3c');
                    }
                });
            });

            function startTimer() {
                let time = 60;
                let interval = setInterval(function() {
                    time--;
                    $('#timer').text(time);

                    if (time <= 0) {
                        clearInterval(interval);
                        $('#timer-box').html('<a href="#" onclick="location.reload()" class="text-success fw-bold">ارسال مجدد کد</a>');
                    }
                }, 1000);
            }
        });
    </script>
</body>
</html>
