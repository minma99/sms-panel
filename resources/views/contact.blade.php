@extends('user.layouts.main')

@section('title', 'تماس با ما')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card section-card h-100">
                <div class="card-body p-4 p-md-5">
                    <h1 class="fw-bold mb-4">تماس با ما</h1>

                    <p class="text-muted mb-4" style="line-height: 2;">
                        برای دریافت اطلاعات بیشتر، پیگیری امور آموزشی و ارتباط با مجموعه
                        می‌توانید از راه‌های زیر با ما در تماس باشید.
                    </p>

                    <div class="mb-3">
                        <strong>نام مجموعه:</strong>
                        <div>آموزشگاه تفکر نو</div>
                    </div>

                    <div class="mb-3">
                        <strong>آدرس:</strong>
                        <div>خیابان یک‌شه‌وه، کوچه لاچین 3</div>
                    </div>

                    <div class="mb-3">
                        <strong>تلفن ثابت:</strong>
                        <div>04446284124</div>
                    </div>

                    <div class="mb-3">
                        <strong>شماره موبایل:</strong>
                        <div>09109915180</div>
                    </div>

                    <div class="mb-3">
                        <strong>ایمیل:</strong>
                        <div>mina.mamrasouli1999@gmail.com</div>
                    </div>

                    <div class="mb-3">
                        <strong>ساعات پاسخگویی:</strong>
                        <div>شنبه تا پنجشنبه - 9 صبح تا 6 عصر</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card section-card h-100">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-4">فرم تماس</h3>

                    <form>
                        <div class="mb-3">
                            <label class="form-label">نام و نام خانوادگی</label>
                            <input type="text" class="form-control rounded-3">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">شماره تماس</label>
                            <input type="text" class="form-control rounded-3">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ایمیل</label>
                            <input type="email" class="form-control rounded-3">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">پیام شما</label>
                            <textarea rows="5" class="form-control rounded-3"></textarea>
                        </div>

                        <button type="button" class="btn btn-success rounded-3 px-4">
                            ارسال پیام
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
