<?php

namespace App\Models;

use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountSnapshot extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;

    protected $fillable = ['account_id', 'company_id', 'debit', 'credit'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
