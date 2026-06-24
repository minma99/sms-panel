@extends('layouts.admin')

@section('title', 'تنظیمات پیامک')
@section('page_title', 'تنظیمات پیامک')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">تنظیمات سرویس پیامک</h5>
                        <small class="text-muted">این بخش فقط برای سوپرادمین قابل دسترسی است</small>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('superadmin.sms.update') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-12 col-md-4">
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="sms_enabled"
                                        id="sms_enabled"
                                        value="1"
                                        {{ old('sms_enabled', $settings->sms_enabled) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="sms_enabled">
                                        فعال بودن ارسال پیامک
                                    </label>
                                </div>
                                <small class="text-muted">اگر خاموش باشد، هیچ پیامکی ارسال نمی‌شود.</small>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="auto_sms_enabled"
                                        id="auto_sms_enabled"
                                        value="1"
                                        {{ old('auto_sms_enabled', $settings->auto_sms_enabled) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="auto_sms_enabled">
                                        فعال بودن ارسال خودکار
                                    </label>
                                </div>
                                <small class="text-muted">برای پیامک‌های رویدادمحور مثل پرداخت، ثبت‌نام و یادآوری.</small>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="test_mode"
                                        id="test_mode"
                                        value="1"
                                        {{ old('test_mode', $settings->test_mode) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="test_mode">
                                        حالت تست
                                    </label>
                                </div>
                                <small class="text-muted">در این حالت پیامک واقعی ارسال نمی‌شود و فقط لاگ ثبت می‌شود.</small>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="provider" class="form-label">نام سرویس‌دهنده</label>
                                <input
                                    type="text"
                                    name="provider"
                                    id="provider"
                                    class="form-control"
                                    value="{{ old('provider', $settings->provider) }}"
                                    placeholder="مثلاً Kavenegar یا FarazSMS"
                                >
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="sender_number" class="form-label">شماره فرستنده</label>
                                <input
                                    type="text"
                                    name="sender_number"
                                    id="sender_number"
                                    class="form-control"
                                    value="{{ old('sender_number', $settings->sender_number) }}"
                                    placeholder="مثلاً 3000xxxxxx"
                                >
                            </div>

                            <div class="col-12">
                                <label for="api_key" class="form-label">API Key</label>
                                <textarea
                                    name="api_key"
                                    id="api_key"
                                    rows="3"
                                    class="form-control"
                                    placeholder="کلید API سرویس پیامک"
                                >{{ old('api_key', $settings->api_key) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="base_url" class="form-label">Base URL</label>
                                <input
                                    type="text"
                                    name="base_url"
                                    id="base_url"
                                    class="form-control"
                                    value="{{ old('base_url', $settings->base_url) }}"
                                    placeholder="مثلاً https://api.kavenegar.com"
                                >
                            </div>

                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                ذخیره تنظیمات
                            </button>

                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                بازگشت
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
