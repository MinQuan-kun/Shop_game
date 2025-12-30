<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Cấu hình chính cho Cloudinary. Đảm bảo biến CLOUDINARY_URL đã có trong .env
    |
    */
    'cloud_url' => env('CLOUDINARY_URL'),

    /**
    * Upload Preset (Tùy chọn)
    */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    /**
    * Notification URL (Tùy chọn)
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),
];