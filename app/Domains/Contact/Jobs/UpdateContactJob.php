<?php

namespace App\Domains\Contact\Jobs;

use App\Models\Contact;
use Lucid\Units\Job;

class UpdateContactJob extends Job
{
    private array $data;
    private Contact $contact;

    public function __construct(Contact $contact, $data = [])
    {
        $this->contact = $contact;
        $this->data    = $data;
    }

    /**
     * Execute the job.
     *
     * @return Contact
     */
    public function handle() : Contact
    {
        Contact::where('id', $this->contact->id)->update($this->data);
        return $this->contact;
    }
}
