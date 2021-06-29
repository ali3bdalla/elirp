<?php

namespace App\Services\Inventory\Operations;

use App\Models\Document;
use Lucid\Units\Operation;

class RegisterRecievedDocumentInventoryTransactionsOperation extends Operation
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(public Document $document)
    {
        //
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle()
    {
    }
}
