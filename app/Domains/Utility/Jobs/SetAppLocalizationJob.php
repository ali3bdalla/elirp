<?php

namespace App\Domains\Utility\Jobs;

use Illuminate\Support\Facades\App;
use Lucid\Units\Job;

class SetAppLocalizationJob extends Job
{
    private string $locale;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($locale = 'ar-SA')
    {
        //
        $this->locale = $locale;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        App::setLocale($this->locale);
    }
}
