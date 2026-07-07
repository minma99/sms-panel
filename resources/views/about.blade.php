@extends('user.layouts.main')

@section('title', 'درباره ما | آموزشگاه تفکر نو')

@push('styles')
<style>
    /* استفاده از استایل‌های یکپارچه با سایر صفحات */
    :root {
        --brand-green: #2ecc71;
        --brand-green-dark: #27ae60;
        --brand-yellow: #f4c542;
        --brand-navy: #1e293b;
        --glass: rgba(255, 255, 255, 0.65);
        --glass-border: rgba(255, 255, 255, 0.8);
    }

    .about-page-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 170px);
        background: radial-gradient(circle at 10% 20%, rgba(46, 204, 113, 0.1) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(244, 197, 66, 0.1) 0%, transparent 40%);
        padding: 24px;
        overflow: hidden;
    }

    /* همان انیمیشن‌های Blob */
    .blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        z-index: 0;
        opacity: 0.5;
        animation: moveBlob 15s infinite alternate;
    }
    .blob-1 { width: 300px; height: 300px; background: var(--brand-green); top: -100px; right: 10%; }
    .blob-2 { width: 250px; height: 250px; background: var(--brand-yellow); bottom: -50px; left: 10%; animation-delay: -5s; }

    @keyframes moveBlob {
        from { transform: translate(0, 0); }
        to { transform: translate(50px, 80px); }
    }

    .about-main-container {
        position: relative;
        z-index: 1;
        display: flex;
        width: 100%;
        max-width: 1000px;
        background: var(--glass);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 40px;
        overflow: hidden;
        min-height: 500px;
    }

    .about-visual-section {
        flex: 1;
        background: rgba(255, 255, 255, 0.3);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .about-content-section {
        flex: 1.5;
        padding: 50px;
        background: white;
        overflow-y: auto;
    }

    .about-title { font-weight: 800; font-size: 2rem; color: var(--brand-navy); margin-bottom: 20px; }
    .about-text { color: #475569; line-height: 1.8; margin-bottom: 20px; }
    
    .features-list { list-style: none; padding: 0; }
    .features-list li {
        background: #f8fafc;
        margin-bottom: 12px;
        padding: 15px;
        border-radius: 12px;
        border-right: 4px solid var(--brand-green);
        color: var(--brand-navy);
        font-weight: 600;
        transition: 0.3s;
    }
    .features-list li:hover { background: #f1f5f9; transform: translateX(-5px); }

    @media (max-width: 992px) {
        .about-visual-section { display: none; }
    }
</style>
@endpush

@section('content')
<div class="about-page-wrapper">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="about-main-container">
        <!-- بخش سمت راست (تصویری) -->
        <div class="about-visual-section">
            <svg width="200" height="200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--brand-green); stroke-width: 1;">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
            </svg>
            <h3 class="mt-4" style="color: var(--brand-navy); font-weight: 800;">توسعه دانش</h3>
        </div>

        <!-- بخش محتوا -->
        <div class="about-content-section">
            <h1 class="about-title">درباره ما</h1>
            
            <p class="about-text">
                آموزشگاه تفکر نو با هدف ارتقای سطح مهارت‌های کاربردی و توسعه توانمندی‌های فردی و حرفه‌ای فعالیت می‌کند.
                این مجموعه تلاش دارد با ارائه آموزش‌های به‌روز و کاربردی، بستری مناسب برای رشد آموزشی و شغلی کارآموزان فراهم کند.
            </p>

            <p class="about-text">
                تمرکز ما بر آموزش، پشتیبانی آموزشی و ارائه مسیر یادگیری مؤثر برای کاربران است تا بتوانند
                با آمادگی بیشتر در مسیر پیشرفت شخصی و حرفه‌ای حرکت کنند.
            </p>

            <h4 class="fw-bold mt-4 mb-3" style="color: var(--brand-navy);">خدمات مجموعه</h4>
            <ul class="features-list">
                <li><i class="fas fa-check-circle text-success ml-2"></i> برگزاری دوره‌های آموزشی تخصصی و کاربردی</li>
                <li><i class="fas fa-check-circle text-success ml-2"></i> ارائه خدمات آموزشی برای کارآموزان</li>
                <li><i class="fas fa-check-circle text-success ml-2"></i> پشتیبانی و راهنمایی در فرآیند یادگیری</li>
                <li><i class="fas fa-check-circle text-success ml-2"></i> ارائه بستر مناسب برای مدیریت اطلاعات آموزشی</li>
            </ul>
        </div>
    </div>
</div>
@endsection
