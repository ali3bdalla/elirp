<?php

namespace App\Domains\Company\Jobs;

use App\Models\Company;
use Illuminate\Http\Request;
use Lucid\Units\Job;

class StoreCompanyJob extends Job
{
    private Request $request;
    private $companyName;
    private $companyEmail;

    public function __construct($companyName = '', $companyEmail = '')
    {
        $this->companyName  = $companyName;
        $this->companyEmail = $companyEmail;
    }

    /**
     * Execute the job.
     *
     * @return Company
     */
    public function handle(Request $request) : Company
    {
        return Company::create(
            $request->only(
                [
                'name'     => $this->companyName,
                'email'    => $this->companyEmail,
                'domain'   => '',
                'currency' => 'SAR',
                'locale'   => 'ar-SA',
                'enabled'  => '1',
                ]
            )
        );
    }
}
