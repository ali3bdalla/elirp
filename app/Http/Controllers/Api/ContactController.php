<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\Contact\Features\StoreContactFeature;
use App\Services\Contact\Features\UpdateContactFeature;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store()
    {
       return $this->serve(StoreContactFeature::class);
    }

    public function update(Contact $contact)
    {
       return $this->serve(UpdateContactFeature::class,[
           'contact' => $contact
       ]);
    }
}
