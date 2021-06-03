<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('company_id')) {
    function company_id()
    {
        $user = Auth::user();
        return $user->company_id;
    }
}
