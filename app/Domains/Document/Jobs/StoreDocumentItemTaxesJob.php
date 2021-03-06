<?php

namespace App\Domains\Document\Jobs;

use App\Enums\TaxTypeEnum;
use App\Models\DocumentItem;
use App\Models\DocumentItemTax;
use App\Models\Tax;
use Lucid\Units\Job;

class StoreDocumentItemTaxesJob extends Job
{
    private DocumentItem $documentItem;
    private $taxIds;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DocumentItem $documentItem, $taxIds = null)
    {
        //
        $this->documentItem = $documentItem;
        $this->taxIds       = $taxIds;
    }

    /**
     * Execute the job.
     *
     * @return array<DocumentItemTax>
     */
    public function handle() : array
    {
        $documentItemTaxes = [];
        if ($this->taxIds) {
            $precision          = 2;
            $totalInclusiveRate = Tax::whereIn('id', $this->taxIds)->where('type', TaxTypeEnum::inclusive())->sum('rate');
            $baseRate           = $this->documentItem->total / (1 + $totalInclusiveRate / 100);
            $taxTotal           = 0;

            foreach ((array)$this->taxIds as $key => $taxId) {
                $tax = Tax::findOrFail($taxId);

                $taxAmount = $tax->rate * (double)$this->documentItem->quantity;

                $documentItemTaxes[] = DocumentItemTax::create([
                    'company_id'       => $this->documentItem->company_id,
                    'document_item_id' => $this->documentItem->id,
                    'document_id'      => $this->documentItem->document_id,
                    'tax_id'           => $taxId,
                    'name'             => $tax->name,
                    'amount'           => round($taxAmount, $precision),
                ]);
                $taxTotal += round($taxAmount, $precision);
            }

            $this->documentItem->update([
                'tax' => $taxTotal
            ]);
        }
        return $documentItemTaxes;
    }
}
