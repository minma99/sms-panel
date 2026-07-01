<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود به پنل | آموزشگاه تفکر نو</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 450px;">
        <div class="card-body text-center">
            <h4>آموزشگاه تفکر نو</h4>
            <p>تایید هویت</p>
            
            <!-- محل نمایش کدهای تستی و خطاهای احتمالی -->
            <div id="result" class="my-3"></div>
            
            <div class="mb-3">
                <input type="text" id="phone" class="form-control text-center" placeholder="شماره موبایل" value="09998429219">
            </div>
            <button id="sendOtpBtn" class="btn btn-primary w-100">ارسال کد</button>

            <!-- بخش ورود کد OTP که پس از ارسال درخواست اول نمایان می‌شود -->
            <div id="otpSection" class="mt-4" style="display:none;">
                <div class="mb-3">
                    <input type="text" id="otp" class="form-control text-center" placeholder="کد ۶ رقمی را اینجا وارد کنید">
                </div>
                <button id="verifyOtpBtn" class="btn btn-success w-100">ورود به پنل کاربری</button>
            </div>
        </div>
    </div>
</div>

<script>
const csrf = "{{ csrf_token() }}";

// ۱. مرحله اول: درخواست و دریافت کد OTP تستی
document.getElementById('sendOtpBtn').onclick = function() {
    let phone = document.getElementById('phone').value;
    
    // پاک کردن وضعیت قبلی هشدارها
    document.getElementById('result').innerHTML = '';
    
    fetch('/send-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({ phone: phone })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            // نمایش بخش وارد کردن کد تایید
            document.getElementById('otpSection').style.display = 'block';
            
            // نمایش کد ۶ رقمی تستی به صورت کاملاً واضح در صفحه جهت کپی کردن
            document.getElementById('result').innerHTML = `
                <div class="alert alert-warning border border-warning text-dark">
                    <strong>کد تستی تولید شده: </strong>
                    <span class="fs-4 fw-bold text-danger">${data.otp}</span>
                    <br>
                    <small class="text-muted">کد بالا را کپی کرده و در کادر پایین وارد کنید.</small>
                </div>`;
        } else {
            document.getElementById('result').innerHTML = `
                <div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(err => {
        document.getElementById('result').innerHTML = `
            <div class="alert alert-danger">خطایی در برقراری ارتباط با سرور رخ داده است.</div>`;
    });
};

// ۲. مرحله دوم: ارسال کد وارد شده جهت احراز هویت و لاگین
document.getElementById('verifyOtpBtn').onclick = function() {
    let phone = document.getElementById('phone').value;
    let otp = document.getElementById('otp').value;
    
    fetch('/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({ phone: phone, otp: otp })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            // هدایت کاربر به داشبورد اختصاصی خود (ادمین یا کارآموز)
            window.location.href = data.redirect;
        } else {
            document.getElementById('result').innerHTML = `
                <div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(err => {
        document.getElementById('result').innerHTML = `
            <div class="alert alert-danger">خطایی در ثبت و تایید کد رخ داده است.</div>`;
    });
};
</script>
</body>
</html>
