<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود | آموزشگاه تفکر نو</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h4 class="text-center">آموزشگاه تفکر نو</h4>
            <div id="result" class="my-3"></div>
            
            <div class="mb-3">
                <input type="text" id="phone" class="form-control" placeholder="شماره موبایل (09...)" value="09998429219">
            </div>
            <button id="sendOtpBtn" class="btn btn-primary w-100">ارسال کد</button>

            <div id="otpSection" class="mt-4" style="display:none;">
                <div class="mb-3">
                    <input type="text" id="otp" class="form-control" placeholder="کد تایید">
                </div>
                <button id="verifyOtpBtn" class="btn btn-success w-100">ورود</button>
            </div>
        </div>
    </div>
</div>

<script>
const csrf = "{{ csrf_token() }}";

// ارسال کد
document.getElementById('sendOtpBtn').onclick = function() {
    let phone = document.getElementById('phone').value;
    fetch('/send-otp', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf},
        body: JSON.stringify({phone: phone})
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('otpSection').style.display = 'block';
            document.getElementById('result').innerHTML = `<div class="alert alert-info">کد تست: ${data.otp}</div>`;
        } else {
            document.getElementById('result').innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    });
};

// تایید کد
document.getElementById('verifyOtpBtn').onclick = function() {
    let phone = document.getElementById('phone').value;
    let otp = document.getElementById('otp').value;
    fetch('/verify-otp', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf},
        body: JSON.stringify({phone: phone, otp: otp})
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            window.location.href = data.redirect;
        } else {
            document.getElementById('result').innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    });
};
</script>
</body>
</html>
