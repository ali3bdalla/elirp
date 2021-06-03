<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Enums\AccountSlugsEnum;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Account extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;
    protected $fillable = ['company_id', 'name', 'number', 'enabled', 'attribute_1', 'attribute_2', 'attribute_3', 'group', 'type', 'auto_generated', 'slug', 'parent_id'];
    
    public static function default(AccountSlugsEnum $enum)
    {
        return (new static)->where('slug', $enum)->first();
    }
    public function tax()
    {
        return $this->hasOne(Tax::class,'account_id');
    }
    
    
}
