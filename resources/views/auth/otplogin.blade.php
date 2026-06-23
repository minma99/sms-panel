<!DOCTYPE html>
<html lang="fa">
<head>
<meta charset="UTF-8">
<title>ورود با OTP</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

.otp-box{
width:45px;
height:45px;
font-size:22px;
text-align:center;
margin:4px;
}

</style>

</head>

<body class="bg-light">

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-4">

<div class="card">
<div class="card-body text-center">

<h5 class="mb-4">ورود با شماره موبایل</h5>

<input type="text" id="phone" class="form-control mb-3" placeholder="شماره موبایل">

<button id="sendOtpBtn" class="btn btn-primary w-100">
ارسال کد
</button>

<div id="timer" class="mt-2 text-muted"></div>

<div id="otpSection" style="display:none" class="mt-4">

<div class="d-flex justify-content-center">

<input type="text" maxlength="1" class="otp-box form-control">
<input type="text" maxlength="1" class="otp-box form-control">
<input type="text" maxlength="1" class="otp-box form-control">
<input type="text" maxlength="1" class="otp-box form-control">
<input type="text" maxlength="1" class="otp-box form-control">
<input type="text" maxlength="1" class="otp-box form-control">

</div>

<button id="verifyOtpBtn" class="btn btn-success w-100 mt-3">
تایید کد
</button>

</div>

<div id="result" class="mt-3"></div>

</div>
</div>

</div>
</div>
</div>


<script>

const csrf = "{{ csrf_token() }}";

let countdown = 60;
let timerInterval;

function startTimer(){

countdown = 60;

document.getElementById('sendOtpBtn').disabled = true;

timerInterval = setInterval(function(){

countdown--;

document.getElementById('timer').innerText =
"ارسال مجدد تا "+countdown+" ثانیه";

if(countdown <= 0){

clearInterval(timerInterval);

document.getElementById('sendOtpBtn').disabled = false;

document.getElementById('timer').innerText =
"می‌توانید دوباره ارسال کنید";

}

},1000);

}


document.getElementById('sendOtpBtn').onclick = function(){

let phone = document.getElementById('phone').value;

fetch('/send-otp',{
method:'POST',
headers:{
'Content-Type':'application/json',
'X-CSRF-TOKEN':csrf
},
body:JSON.stringify({phone:phone})
})
.then(res=>res.json())
.then(data=>{

if(data.success){

document.getElementById('otpSection').style.display='block';

document.getElementById('result').innerHTML =
'<div class="alert alert-success">کد تست: '+data.otp+'</div>';

startTimer();

}

});

};



document.querySelectorAll('.otp-box').forEach((input,index,arr)=>{

input.addEventListener('input',function(){

if(this.value.length==1 && index<5){
arr[index+1].focus();
}

});

});


document.getElementById('verifyOtpBtn').onclick=function(){

let phone = document.getElementById('phone').value;

let code='';

document.querySelectorAll('.otp-box').forEach(i=>{
code+=i.value;
});

fetch('/verify-otp',{
method:'POST',
headers:{
'Content-Type':'application/json',
'X-CSRF-TOKEN':csrf
},
body:JSON.stringify({
phone:phone,
code:code
})
})
.then(res=>res.json())
.then(data=>{

if(data.success){

window.location.href=data.redirect;

}else{

document.getElementById('result').innerHTML =
'<div class="alert alert-danger">'+data.message+'</div>';

}

});

};

</script>

</body>
</html>
