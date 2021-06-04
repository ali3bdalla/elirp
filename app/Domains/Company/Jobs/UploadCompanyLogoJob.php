<?php

namespace App\Domains\Company\Jobs;

use App\Models\Company;
use App\Traits\Uploads;
use Illuminate\Http\Request;
use Lucid\Units\Job;

class UploadCompanyLogoJob extends Job
{
//    use Uploads;

    private Company $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        //
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return null
     */
    public function handle(Request $request)
    {
        return null;
//        if ($request->file('logo')) {
//            $company_logo = $this->getMedia($request->file('logo'), 'settings', $this->company->id);
//
//            if ($company_logo) {
//                $this->company->attachMedia($company_logo, 'company_logo');
//            }
//        }

//        return $company_logo;
    }
}
