<?php

namespace App\Services\Contact\Features;

use App\Domains\Contact\Jobs\StoreContactJob;
use App\Domains\Contact\Jobs\ValidateContactJob;
use Illuminate\Http\Request;
use Lucid\Units\Feature;

class StoreContactFeature extends Feature
{
    public function handle(Request $request)
    {
        $this->run(ValidateContactJob::class,[
            'request' => $request->all()
        ]);

        return $this->run(StoreContactJob::class,[
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
