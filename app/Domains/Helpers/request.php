<?php

use Illuminate\Foundation\Http\FormRequest;

if (! function_exists('parse_request_instance')) {
    function parse_request_instance($request)
    {
        if (! is_array($request)) {
            return $request;
        }

        $class = new class() extends FormRequest {
        };

        return $class->merge($request);
    }
}
