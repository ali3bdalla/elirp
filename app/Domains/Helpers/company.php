<?php

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Optional;

if (!function_exists('company_id')) {
    function company_id()
    {
        return webUser()?->company_id;
    }
}
if (!function_exists('company')) {
    function company()
    {
        return webUser()?->company;
    }
}
if (!function_exists('webUser')) {
    function webUser()
    {
        return Auth::guard('web')->user();
    }
}
if (!function_exists('user_id')) {
    function user_id()
    {
        return webUser()?->id;
    }
}
