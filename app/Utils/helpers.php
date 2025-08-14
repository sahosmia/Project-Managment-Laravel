<?php

use App\Models\User;
use Carbon\Carbon;

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
