<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(! app()->isProduction());
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        Validator::extendImplicit(
            'currency',
            function ($attribute, $value, $parameters, $validator) use (&$currency_code) {
                return true;
//                $status = false;
//
//                if (!is_string($value) || (strlen($value) != 3)) {
//                    return $status;
//                }
//
//                $currencies = Currency::enabled()->pluck('code')->toArray();
//
//                if (in_array($value, $currencies)) {
//                    $status = true;
//                }
//
//                $currency_code = $value;
//
//                return $status;
            },
            trans('validation.custom.invalid_currency', ['attribute' => $currency_code])
        );

        $amount = null;

        Validator::extendImplicit(
            'amount',
            function ($attribute, $value, $parameters, $validator) use (&$amount) {
                $status = false;

                if ($value >= 0) {
                    $status = true;
                }

                $amount = $value;

                return $status;
            },
            trans('validation.custom.invalid_amount', ['attribute' => $amount])
        );

        Validator::extend(
            'extension',
            function ($attribute, $value, $parameters, $validator) {
                $extension = $value->getClientOriginalExtension();

                return ! empty($extension) && in_array($extension, $parameters);
            },
            trans('validation.custom.invalid_extension')
        );

        Model::preventLazyLoading(! app()->isProduction());
        Model::handleLazyLoadingViolationUsing(function () {
            Log::error('Error');
        });
    }
}
