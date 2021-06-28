<?php

namespace App\Services\Contact\Features;

use App\Domains\Contact\Jobs\UpdateContactJob;
use App\Domains\Contact\Jobs\ValidateContactJob;
use App\Models\Contact;
use Illuminate\Http\Request;
use Lucid\Units\Feature;

class UpdateContactFeature extends Feature
{
    private Contact $contact;
    public function __construct( Contact $contact)
    {
        $this->contact = $contact;
    }
    public function handle(Request $request)
    {
        $this->run(ValidateContactJob::class,[
            'request' => $request->all()
        ]);

        return $this->run(UpdateContactJob::class,[
            'contact' => $this->contact,
            'data' => $request->only(
                    'email'       ,
                    'reference'     ,
                    'website'      ,
                    'tax_number'   ,
                    'phone'      ,
                    'address'   ,
                    'is_vendor'  ,
                    'is_customer'  ,
                    'currency_code'  ,
                    'name'          ,
            )
            ]);
    }
}
