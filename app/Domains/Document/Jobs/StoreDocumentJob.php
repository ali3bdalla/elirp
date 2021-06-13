<?php

namespace App\Domains\Document\Jobs;

use App\Enums\DocumentTypeEnum;
use App\Models\Contact;
use App\Models\Document;
use Illuminate\Foundation\Http\FormRequest;
use Lucid\Units\Job;

class StoreDocumentJob extends Job
{
    private FormRequest $request;
    private DocumentTypeEnum $documentTypeEnum;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, DocumentTypeEnum $documentTypeEnum)
    {
        //
        $this->request          = parse_request_instance($request);
        $this->documentTypeEnum = $documentTypeEnum;
    }

    /**
     * Execute the job.
     *
     */
    public function handle() : ?Document
    {
        $this->request->validate([
            'contact_id'      => 'required|integer|exists:contacts,id',
            'document_number' => 'required|string',
            'amount'          => 'required|numeric',
            'status'          => 'required|string',
            'issued_at'       => 'required|date',
            'due_at'          => 'required|date',
            'currency_code'   => 'required|string|currency',
            'currency_rate'   => 'required|numeric',
        ]);
        $contact                   = Contact::find($this->request->input('contact_id'));
        $document                  = new Document();
        $document->type            = $this->documentTypeEnum;
        $document->company_id      = company_id();
        $document->contact_id      = $this->request->input('contact_id');
        $document->document_number = $this->request->input('document_number');
        $document->contact_name    = $contact->name;
        $document->contact_email   = $contact->email;
        $document->contact_phone   = $contact->phone;
        $document->contact_address = $contact->address;
        $document->footer          = $this->request->input('footer');
        $document->notes           = $this->request->input('notes');
        $document->amount          = $this->request->input('amount');
        $document->issued_at       = $this->request->input('issued_at');
        $document->due_at          = $this->request->input('due_at');
        $document->status          = $this->request->input('status');
        $document->currency_code   = $this->request->input('currency_code');
        $document->currency_rate   = $this->request->input('currency_rate');
        $document->save();
        return $document->fresh();
    }
}
