<?php

namespace App\Domains\Document\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Recurring;
use App\Models\Document;
use Lucid\Units\Job;

class CreateDocumentRecurringJob extends Job
{
    private Document $document;
    private FormRequest $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Document $document, $request)
    {
        //
        $this->document = $document;
        $this->request = parse_request_instance($request);
    }

    /**
     * Execute the job.
     *
     * @return Recurring
     */
    public function handle(): ?Recurring
    {
        $this->request->validate([
            'recurring_frequency' => 'nullable|string|in:no,yes',
        ]);
        if ($this->request->input('recurring_frequency', 'no') == 'yes') {
            $this->request->validate([
                'recurring_interval' => 'required|integer',
                'recurring_custom_frequency' => 'required|string|in:monthly,weekly',
                'recurring_count' => 'required|integer',
            ]);
//            return $this->document->createRecurring($this->request);
        }

        return null;
    }
}
