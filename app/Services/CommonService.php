<?php
namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class CommonService
{
    public function getSetting($key, $default = null)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }
}
