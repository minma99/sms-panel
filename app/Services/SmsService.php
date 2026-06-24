<?php

namespace App\Services;

use App\Models\SmsLog;
use App\Models\SmsSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SmsService
{
    public function getSettings(): SmsSetting
    {
        return SmsSetting::firstOrCreate(
            ['id' => 1],
            [
                'sms_enabled' => false,
                'auto_sms_enabled' => false,
                'test_mode' => true,
                'provider' => null,
                'api_key' => null,
                'sender_number' => null,
                'base_url' => null,
            ]
        );
    }

    public function sendManual(string $mobile, string $message, $related = null): SmsLog
    {
        return $this->send(
            mobile: $mobile,
            message: $message,
            type: 'manual',
            related: $related,
            isAuto: false
        );
    }

    public function sendAuto(string $mobile, string $message, $related = null, ?string $templateKey = null): SmsLog
    {
        return $this->send(
            mobile: $mobile,
            message: $message,
            type: 'auto',
            related: $related,
            isAuto: true,
            templateKey: $templateKey
        );
    }

    protected function send(
        string $mobile,
        string $message,
        string $type = 'manual',
        $related = null,
        bool $isAuto = false,
        ?string $templateKey = null
    ): SmsLog {
        $settings = $this->getSettings();

        $logData = [
            'mobile' => $mobile,
            'message' => $message,
            'type' => $type,
            'status' => 'pending',
            'provider' => $settings->provider,
            'template_key' => $templateKey,
            'user_id' => Auth::id(),
        ];

        if ($related) {
            $logData['related_type'] = get_class($related);
            $logData['related_id'] = $related->id;
        }

        $log = SmsLog::create($logData);

        if (! $settings->sms_enabled) {
            $log->update([
                'status' => 'cancelled',
                'error_message' => 'SMS system is disabled.',
            ]);

            return $log;
        }

        if ($isAuto && ! $settings->auto_sms_enabled) {
            $log->update([
                'status' => 'pending',
                'error_message' => 'Auto SMS is disabled.',
            ]);

            return $log;
        }

        if ($settings->test_mode) {
            $log->update([
                'status' => 'test',
                'response' => 'Test mode enabled. SMS not sent.',
            ]);

            return $log;
        }

        try {
            $result = $this->sendViaProvider(
                mobile: $mobile,
                message: $message,
                settings: $settings
            );

            $log->update([
                'status' => 'sent',
                'provider_message_id' => $result['message_id'] ?? null,
                'response' => $result['response'] ?? null,
                'sent_at' => now(),
            ]);
        } catch (\Throwable $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }

        return $log;
    }

    protected function sendViaProvider(string $mobile, string $message, SmsSetting $settings): array
    {
        // فعلاً mock
        // بعداً اینجا به API واقعی مثل کاوه نگار یا ملی پیامک وصل می‌کنیم

        return [
            'message_id' => uniqid('sms_'),
            'response' => 'Mock SMS sent successfully.',
        ];
    }
}
