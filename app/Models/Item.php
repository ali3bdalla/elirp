<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed sale_price
 * @property mixed sku
 * @property mixed description
 * @property mixed purchase_price
 * @property mixed fixed_price
 * @property mixed is_service
 * @property mixed has_detail
 * @property mixed name
 * @property \Illuminate\Support\HigherOrderCollectionProxy|mixed company_id
 */
class Item extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;
}
