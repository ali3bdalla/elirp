<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('company_id')) {
    function company_id()
    {
        $user = Auth::user();
        return $user->company_id;
    }
}
if (! function_exists('company')) {
    function company()
    {
        $user = Auth::web('web')->user();
        return $user->company;
    }
}

if (! function_exists('user_id')) {
    function user_id()
    {
        return Auth::user()->id;
    }
}
