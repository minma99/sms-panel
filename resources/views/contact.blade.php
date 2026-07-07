@extends('user.layouts.main')

@section('title', 'تماس با ما | آموزشگاه تفکر نو')

@push('styles')
<style>
    .contact-page-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 170px);
        background:
            radial-gradient(circle at 10% 20%, rgba(46, 204, 113, 0.10) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(244, 197, 66, 0.10) 0%, transparent 40%);
        padding: 24px;
        overflow: hidden;
    }

    .contact-blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        z-index: 0;
        opacity: 0.5;
        animation: moveContactBlob 15s infinite alternate;
    }

    .contact-blob-1 {
        width: 300px;
        height: 300px;
        background: var(--brand-green);
        top: -100px;
        right: 10%;
    }

    .contact-blob-2 {
        width: 250px;
        height: 250px;
        background: var(--brand-yellow);
        bottom: -50px;
        left: 10%;
        animation-delay: -5s;
    }

    @keyframes moveContactBlob {
        from { transform: translate(0, 0); }
        to { transform: translate(50px, 80px); }
    }

    .contact-main-container {
        position: relative;
        z-index: 1;
        display: flex;
        width: 100%;
        max-width: 1100px;
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.10);
        overflow: hidden;
        min-height: 650px;
    }

    .contact-visual-section {
        flex: 1.05;
        background: rgba(255, 255, 255, 0.25);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px;
        position: relative;
        text-align: center;
    }

    .contact-badge {
        position: absolute;
        top: 20%;
        right: 15%;
        background: var(--brand-yellow);
        color: #fff;
        padding: 8px 15px;
        border-radius: 12px;
        font-weight: 800;
        box-shadow: 0 10px 20px rgba(244, 197, 66, 0.3);
        animation: floatContactCard 5s ease-in-out infinite reverse;
    }

    .contact-vector-box {
        width: 100%;
        max-width: 420px;
        animation: floatContactCard 4s ease-in-out infinite;
    }

    @keyframes floatContactCard {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-18px); }
    }

    .contact-info-text h1 {
        font-weight: 800;
        font-size: 2.1rem;
        color: var(--brand-navy);
        margin-bottom: 12px;
    }

    .contact-info-text p {
        color: #64748b;
        font-size: 1.05rem;
        margin-bottom: 0;
        line-height: 2;
    }

    .contact-details-section {
        flex: 1;
        padding: 42px 34px;
        background: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .contact-title {
        font-weight: 800;
        font-size: 1.8rem;
        color: var(--brand-navy);
        margin-bottom: 8px;
    }

    .contact-subtitle {
        color: #94a3b8;
        margin-bottom: 30px;
        line-height: 2;
    }

    .contact-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 18px;
        transition: 0.3s ease;
    }

    .contact-item:hover {
        transform: translateY(-3px);
        border-color: rgba(46, 204, 113, 0.4);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
    }

    .contact-icon {
        width: 52px;
        height: 52px;
        min-width: 52px;
        border-radius: 16px;
        background: rgba(46, 204, 113, 0.12);
        color: var(--brand-green-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .contact-item-title {
        font-weight: 800;
        color: var(--brand-navy);
        margin-bottom: 4px;
        font-size: 1rem;
    }

    .contact-item-value {
        color: #64748b;
        line-height: 1.9;
        word-break: break-word;
    }

    .contact-item-value a {
        color: var(--brand-green-dark);
        font-weight: 700;
    }

    .contact-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
    }

    .contact-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 16px;
        padding: 14px 20px;
        font-weight: 800;
        transition: 0.3s;
        text-decoration: none;
    }

    .contact-btn-primary {
        background: var(--brand-green);
        color: #fff;
        box-shadow: 0 10px 20px rgba(46, 204, 113, 0.25);
    }

    .contact-btn-primary:hover {
        background: var(--brand-green-dark);
        color: #fff;
        transform: translateY(-2px);
    }

    .contact-btn-outline {
        background: #fff;
        color: var(--brand-navy);
        border: 1px solid #e2e8f0;
    }

    .contact-btn-outline:hover {
        color: var(--brand-green-dark);
        border-color: var(--brand-green);
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .contact-main-container {
            max-width: 560px;
            min-height: auto;
        }

        .contact-visual-section {
            display: none;
        }

        .contact-details-section {
            padding: 34px 24px;
        }
    }

    @media (max-width: 576px) {
        .contact-page-wrapper {
            padding: 12px;
        }

        .contact-main-container {
            border-radius: 24px;
        }

        .contact-details-section {
            padding: 26px 16px;
        }

        .contact-title {
            font-size: 1.5rem;
        }

        .contact-subtitle {
            font-size: 0.95rem;
            margin-bottom: 24px;
        }

        .contact-item {
            padding: 15px;
            border-radius: 16px;
        }

        .contact-icon {
            width: 46px;
            height: 46px;
            min-width: 46px;
            border-radius: 14px;
            font-size: 1rem;
        }

        .contact-btn {
            width: 100%;
        }

        .contact-blob-1 {
            width: 180px;
            height: 180px;
            top: -50px;
        }

        .contact-blob-2 {
            width: 160px;
            height: 160px;
            bottom: -40px;
        }
    }
</style>
@endpush

@section('content')
<div class="contact-page-wrapper">
    <div class="contact-blob contact-blob-1"></div>
    <div class="contact-blob contact-blob-2"></div>

    <div class="contact-main-container">
        <div class="contact-visual-section">
            <div class="contact-badge">Contact Us</div>

            <div class="contact-vector-box">
                <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="contactGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#2ecc71;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#27ae60;stop-opacity:1" />
                        </linearGradient>
                    </defs>

                    <circle cx="250" cy="250" r="200" fill="white" fill-opacity="0.45" />
                    <rect x="110" y="120" width="280" height="190" rx="22" fill="#1e293b" />
                    <rect x="128" y="138" width="244" height="120" rx="14" fill="#f8fafc" />
                    <path d="M145 155 L250 220 L355 155" stroke="#2ecc71" stroke-width="10" fill="none" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M140 300 Q250 210 360 300 L360 360 L140 360 Z" fill="url(#contactGrad)" />
                    <circle cx="165" cy="105" r="14" fill="#f4c542" opacity="0.85" />
                    <circle cx="345" cy="100" r="10" fill="#60a5fa" opacity="0.85" />
                </svg>
            </div>

            <div class="contact-info-text mt-4">
                <h1>ارتباط با آموزشگاه</h1>
                <p>
                    برای پیگیری امور آموزشی، دریافت راهنمایی و ارتباط مستقیم با مجموعه
                    از اطلاعات تماس زیر استفاده کنید.
                </p>
            </div>
        </div>

        <div class="contact-details-section">
            <h2 class="contact-title">تماس با ما</h2>
            <p class="contact-subtitle">
                ما آماده پاسخگویی به سوالات شما هستیم. راه‌های ارتباطی مجموعه در ادامه آورده شده است.
            </p>

            <div class="contact-list">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <div class="contact-item-title">نام مجموعه</div>
                        <div class="contact-item-value">آموزشگاه تفکر نو</div>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="contact-item-title">آدرس</div>
                        <div class="contact-item-value">خیابان یک‌شه‌وه، کوچه لاچین 3</div>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <div class="contact-item-title">تلفن ثابت</div>
                        <div class="contact-item-value">
                            <a href="tel:04446284124">04446284124</a>
                        </div>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div>
                        <div class="contact-item-title">شماره موبایل</div>
                        <div class="contact-item-value">
                            <a href="tel:09109915180">09109915180</a>
                        </div>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <div class="contact-item-title">ایمیل</div>
                        <div class="contact-item-value">
                            <a href="mailto:mina.mamrasouli1999@gmail.com">mina.mamrasouli1999@gmail.com</a>
                        </div>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="contact-item-title">ساعات پاسخگویی</div>
                        <div class="contact-item-value">شنبه تا پنجشنبه، 9 صبح تا 6 عصر</div>
                    </div>
                </div>
            </div>

            <div class="contact-actions">
                <a href="tel:09109915180" class="contact-btn contact-btn-primary">
                    <i class="fas fa-phone"></i>
                    تماس مستقیم
                </a>

                <a href="mailto:mina.mamrasouli1999@gmail.com" class="contact-btn contact-btn-outline">
                    <i class="fas fa-paper-plane"></i>
                    ارسال ایمیل
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
