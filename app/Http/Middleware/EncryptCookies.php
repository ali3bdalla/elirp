<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    public function __construct(EncrypterContract $encrypter)
    {
        parent::__construct($encrypter);

        /**
         * This will disable in runtime.
         *
         * If you have a "session.cookie" option or don't care about changing the app name
         * (in another environment, for example), you can only add it to "$except" array on top
         */
        $this->disableFor(config('session.cookie'));
    }

    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
