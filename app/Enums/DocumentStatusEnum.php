<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self draft()
 * @method static self received()
 * @method static self paid()
 * @method static self invoiced()
 * @method static self cancelled()
 * @method static self completed()
 * @method static self shipped()
 * @method static self refunded()
 * @method static self billed()
 * @method static self delivered()
 * @method static self returned()
 **/
class DocumentStatusEnum extends Enum
{
    use ResolvesAsOptions;

    public static function invoice_statuses()
    {
        return [
            static::draft()->value     => static::draft()->label,
            static::delivered()->value => static::delivered()->label,
            static::completed()->value => static::completed()->label,
            static::returned()->value  => static::returned()->label,
            static::cancelled()->value => static::cancelled()->label,
            static::paid()->value      => static::paid()->label,
            static::invoiced()->value  => static::invoiced()->label,
            static::shipped()->value   => static::shipped()->label,
        ];
    }

    public static function bill_statuses()
    {
        return [
            static::draft()->value     => static::draft()->label,
            static::received()->value  => static::received()->label,
            static::completed()->value => static::completed()->label,
            static::refunded()->value  => static::refunded()->label,
            static::cancelled()->value => static::cancelled()->label,
            static::paid()->value      => static::paid()->label,
            static::billed()->value    => static::billed()->label,
        ];
    }
}
