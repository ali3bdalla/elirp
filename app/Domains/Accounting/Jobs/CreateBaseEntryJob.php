<?php

namespace App\Domains\Accounting\Jobs;

use App\Models\Entry;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Job;

class CreateBaseEntryJob extends Job
{
    /**
     * @var null
     */
    private $documentId;
    private $description;
    /**
     * @var false
     */
    private $isPending;
    private $amount;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($documentId = null, $description = "", $isPending = false, $amount = 0)
    {
        //
        $this->documentId = $documentId;
        $this->description = $description;
        $this->isPending = $isPending;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() : Entry
    {
       
        return Entry::create([
            'company_id' => company_id(),
            'document_id' => $this->documentId,
            'description' => $this->description,
            'is_pending' => $this->isPending,
            'amount' => $this->amount
        ]);
    }
}
