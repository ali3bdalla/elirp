<?php

namespace App\Enums;

use App\Models\Account;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self DEFAULT_SALES_INCOMES_ACCOUNT()
 * @method static self DEFAULT_COGS_ACCOUNT()
 * @method static self DEFAULT_PAYABLE_ACCOUNT()
 * @method static self DEFAULT_RECEIVABLE_ACCOUNT()
 * @method static self DEFAULT_BANK_ACCOUNT()
 * @method static self DEFAULT_STOCK_ACCOUNT()
 * @method static self DEFAULT_TAX_ACCOUNT()
 * @method static self DEFUALT_SALES_DISCOUNTS_ACCOUNT()
 */
class AccountSlugsEnum extends Enum
{
    public static function getAccount($slug)
    {
        return Account::where('slug', $slug)->first();
    }
}
