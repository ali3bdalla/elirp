<?php

namespace App\Models;

use App\Data\CanBeEnabled;
use App\Data\HasCompany;
use App\Data\HasFullSearch;
use App\Data\HasUserActions;
use App\Enums\DocumentTypeEnum;
use App\Frame\ModelFrame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @property \Illuminate\Support\HigherOrderCollectionProxy|mixed company_id
 * @property mixed contact_address
 * @property mixed contact_phone
 * @property mixed contact_email
 * @property mixed contact_name
 * @property mixed document_number
 * @property mixed contact_id
 * @property DocumentTypeEnum type
 * @property mixed footer
 * @property mixed notes
 * @property null|integer|mixed parent_id
 * @property mixed amount
 * @property mixed issued_at
 * @property mixed due_at
 * @property mixed status
 * @property mixed currency_code
 * @property mixed currency_rate
 * @property mixed histories()
 * @property integer id
 * @property Contact contact
 */
class Document extends ModelFrame
{
    use HasFullSearch;
    use HasFactory;
    use SoftDeletes;
    use HasCompany;
    use HasUserActions;
    use CanBeEnabled;

    protected $casts = [
        'type' => DocumentTypeEnum::class
    ];
    protected $fillable = [
        'company_id',
        'type',
        'document_number',
        'order_number',
        'status',
        'issued_at',
        'due_at',
        'amount',
        'currency_code',
        'currency_rate',
        'contact_id',
        'contact_name',
        'contact_email',
        'contact_tax_number',
        'contact_phone',
        'contact_address',
        'notes',
        'category_id',
        'parent_id',
        'footer',
    ];

    public function itemsTaxes() : HasMany
    {
        return $this->hasMany(DocumentItemTax::class, 'document_id');
    }

    public static function generatedNextDocumentNumber(DocumentTypeEnum $documentTypeEnum)
    {
        return Str::upper(Str::singular($documentTypeEnum->value)).Str::studly(Carbon::now()->toDateString()).company_id().Auth::id().random_int(3, 10).random_int(10000, 999999);
    }

    public function contact() : BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function items() : HasMany
    {
        return $this->hasMany(DocumentItem::class, 'document_id');
    }

    public function histories() : HasMany
    {
        return $this->hasMany(DocumentHistory::class);
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function inventoryTransactions() : HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'document_id');
    }
}
