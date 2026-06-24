<?php

return [
    'show_warnings' => false,
    'public_path' => null,
    'convert_entities' => true,
    'isHtml5ParserEnabled' => true,
    'isRemoteEnabled' => true, // بسیار مهم برای نمایش تصاویر و لوگو
    'isFontSubsettingEnabled' => true, // برای کاهش حجم فایل PDF با فونت فارسی
    'default_media_type' => 'screen',
    'default_paper_size' => 'a4',
    'default_font' => 'serif',
    'dpi' => 96,
    'enable_php' => false,
    'enable_javascript' => true,
    'enable_remote' => true,
    'font_cache' => storage_path('fonts'),
    'font_dir' => storage_path('fonts'),
];
