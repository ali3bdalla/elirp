<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasUserActions;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed account
 * @property mixed account_id
 * @property mixed amount
 * @property mixed item_id
 * @property Item item
 */
class Transaction extends ModelFrame
{
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;

    protected $fillable = ['company_id', 'type', 'paid_at', 'amount', 'currency_code', 'currency_rate', 'account_id', 'document_id', 'contact_id', 'category_id', 'description', 'reference', 'parent_id', 'reconciled', 'entry_id', 'item_id', 'is_pending', 'inventory_transaction_id'];

    protected $appends = [
        'account_name'
    ];

    public function account() : BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function contact() : BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function getAccountNameAttribute()
    {
        if ($this->item) {
            return $this->item->name;
        }
        if ($this->contact) {
            return $this->account->name.' ('.$this->contact->name.')';
        }
        return $this->account->name;
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function document() : BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
}
