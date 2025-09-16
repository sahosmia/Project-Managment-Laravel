<?php

use App\Models\User;
use App\Models\Setting;

use Carbon\Carbon;

use Illuminate\Support\Facades\Cache;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }
}

if (!function_exists('getRoleList')) {
    /**
     * Get a list of users by role.
     *
     * @param string $role
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function getRoleList(string $role)
    {
        return User::where('role', $role)->get();
    }
}

if (!function_exists('formatTime')) {
    /**
     * Format a timestamp into a human-readable format.
     *
     * @param string|\Carbon\Carbon $timestamp
     * @param string $format
     * @return string
     */
    function formatTime($timestamp, $format = 'M d, Y h:i A')
    {
        return Carbon::parse($timestamp)->format($format);
    }
}
