<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self RECEIPT()
 * @method static self PAYMENT()
 **/

class PaymentTypeEnum extends Enum
{
    // public static function toLabels(): array
    // {
    //     return [
    //         'IR' => "ITEM RECEIVED",
    //         'IO' => "ITEM SOLD",
    //     ];
    // }
}
