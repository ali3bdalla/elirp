<?php

namespace App\Domains\Document\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Document;
use Illuminate\Support\Str;
use Lucid\Units\Job;

class UploadDocumentAttachmentJob extends Job
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
     * @return void
     */
    public function handle()
    {
        $this->request->validate([
           'attachment' => 'nullable|array',
           'attachment.*' => 'required|file'
        ]);

        if ($this->request->file('attachment')) {
            foreach ($this->request->file('attachment') as $attachment) {
                $media = $this->getMedia($attachment, Str::plural($this->document->type));
                $this->document->attachMedia($media, 'attachment');
            }
        }
    }
}
