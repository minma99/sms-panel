<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsSetting;
use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsSettingController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function index()
    {
        $settings = $this->smsService->getSettings();
        return view('admin.sms.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = $this->smsService->getSettings();
        
        $settings->update($request->validate([
            'sms_enabled' => 'boolean',
            'auto_sms_enabled' => 'boolean',
            'test_mode' => 'boolean',
            'provider' => 'nullable|string',
            'api_key' => 'nullable|string',
            'sender_number' => 'nullable|string',
        ]));

        // تبدیل checkboxهای ارسال نشده به false
        if (!$request->has('sms_enabled')) $settings->update(['sms_enabled' => false]);
        if (!$request->has('auto_sms_enabled')) $settings->update(['auto_sms_enabled' => false]);
        if (!$request->has('test_mode')) $settings->update(['test_mode' => false]);

        return back()->with('success', 'تنظیمات با موفقیت ذخیره شد.');
    }
}
