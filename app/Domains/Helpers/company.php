<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('company_id')) {
    function company_id()
    {
        return webUser()->company_id;
    }
}
if (! function_exists('company')) {
    function company()
    {
        return webUser()->company;
    }
}
if (! function_exists('webUser')) {
    function webUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return optional(Auth::guard('web')->user(),function($value) {
            return $value;
        });
    }
}
if (! function_exists('user_id')) {
    function user_id()
    {
        return webUser()->id;
    }
}
