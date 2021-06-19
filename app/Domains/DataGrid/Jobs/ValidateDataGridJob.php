<?php

namespace App\Domains\DataGrid\Jobs;

use Lucid\Units\Job;

class ValidateDataGridJob extends Job
{
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
        $this->request = parse_request_instance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // TODO: default datatable validation
    }
}
