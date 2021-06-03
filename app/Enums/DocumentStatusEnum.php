<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self draft()
 * @method static self sent()
 * @method static self expired()
 * @method static self viewed()
 * @method static self approved()
 * @method static self received()
 * @method static self refused()
 * @method static self restored()
 * @method static self reversed()
 * @method static self partial()
 * @method static self paid()
 * @method static self pending()
 * @method static self invoiced()
 * @method static self overdue()
 * @method static self unpaid()
 * @method static self cancelled()
 * @method static self voided()
 * @method static self completed()
 * @method static self shipped()
 * @method static self refunded()
 * @method static self failed()
 * @method static self denied()
 * @method static self processed()
 * @method static self open()
 * @method static self closed()
 * @method static self billed()
 * @method static self delivered()
 * @method static self returned()
 * @method static self drawn()
 * @method static self not_billed()
 * @method static self issued()
 * @method static self not_invoiced()
 * @method static self not_confirmed()
 **/
class DocumentStatusEnum extends Enum
{
}
