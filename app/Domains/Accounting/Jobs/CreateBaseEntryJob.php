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
    private string $description;
    /**
     * @var false
     */
    private bool $isPending;
    private int $amount;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($documentId = null, $description = "", $isPending = false, int $amount = 0)
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
    public function handle()
    {
        $user = Auth::user();
        return Entry::create([
            'company_id' => $user->company_id,
            'document_id' => $this->documentId,
            'description' => $this->description,
            'is_pending' => $this->isPending,
            'amount' => $this->amount
        ]);
    }
}
