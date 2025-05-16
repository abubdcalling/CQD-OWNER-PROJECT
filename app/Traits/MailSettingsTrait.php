<?php

namespace App\Traits;

use Cache;

trait MailSettingsTrait
{
    protected function getSettings()
    {
        if (!Cache::has('settings')) {
            $settings = \App\Models\SystemSetting::first() ?? [];
            Cache::rememberForever('settings', fn() => $settings);
        }
        return Cache::get('settings');
    }

    protected function getLogo($settings)
    {
        if (!Cache::has('logo')) {
            $path = public_path($settings['logo'] ?? 'logo.png');
            $path = file_exists($path) ? $path : public_path('logo.png');

            $fileContent = file_get_contents($path);
            $base64String = base64_encode($fileContent);
            $mimeType = mime_content_type($path);

            $logo = "data:$mimeType;base64,$base64String";
            Cache::rememberForever('logo', fn() => $logo);
        } else {
            $logo = Cache::get('logo');
        }
        return $logo;
    }
}
