<?php

namespace App\Domains\Company\Jobs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Job;
use Illuminate\Validation\Rules\Password;

class ValidateCreateCompanyJob extends Job
{

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        $request->validate($rules);
    }
}
