<div class="row g-3">

{{-- کارآموز --}}
<div class="col-md-6">
<label class="form-label">کارآموز</label>
<select name="trainee_id" class="form-select" required>
@foreach($trainees as $trainee)
<option value="{{ $trainee->id }}"
{{ old('trainee_id') == $trainee->id ? 'selected' : '' }}>
{{ $trainee->name }}
</option>
@endforeach
</select>
</div>

{{-- مبلغ --}}
<div class="col-md-6">
<label class="form-label">مبلغ</label>
<input type="number"
name="amount"
value="{{ old('amount') }}"
class="form-control"
required>
</div>

{{-- نوع پرداخت --}}
<div class="col-md-6">
<label class="form-label">نوع پرداخت</label>
<select name="payment_type" class="form-select">
<option value="installment">قسطی</option>
<option value="full">کامل</option>
</select>
</div>

{{-- روش پرداخت --}}
<div class="col-md-6">
<label class="form-label">روش پرداخت</label>
<select name="payment_method" class="form-select">
<option value="cash">نقدی</option>
<option value="card">کارت</option>
<option value="online">آنلاین</option>
</select>
</div>

{{-- کد رهگیری --}}
<div class="col-md-6">
<label class="form-label">کد رهگیری</label>
<input type="text"
name="tracking_code"
value="{{ old('tracking_code') }}"
class="form-control">
</div>

{{-- تاریخ میلادی --}}
<div class="col-md-6">
<label class="form-label">تاریخ پرداخت</label>
<input type="date"
name="payment_date"
value="{{ old('payment_date') }}"
class="form-control">
</div>

{{-- تاریخ شمسی --}}
<div class="col-md-6">
<label class="form-label">تاریخ شمسی</label>
<input type="text"
name="payment_date_shamsi"
value="{{ old('payment_date_shamsi') }}"
class="form-control">
</div>

{{-- باقی‌مانده --}}
<div class="col-md-6">
<label class="form-label">باقی‌مانده بعد از پرداخت</label>
<input type="number"
name="remaining_after_payment"
value="{{ old('remaining_after_payment') }}"
class="form-control">
</div>

{{-- توضیحات --}}
<div class="col-md-12">
<label class="form-label">توضیحات</label>
<textarea name="note"
class="form-control">{{ old('note') }}</textarea>
</div>

</div>
