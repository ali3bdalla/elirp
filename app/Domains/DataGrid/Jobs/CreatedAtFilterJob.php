<?php

namespace App\Domains\DataGrid\Jobs;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Lucid\Units\Job;

class CreatedAtFilterJob extends Job
{
    private $request;

    public function __construct($request)
    {
        $this->request = parse_request_instance($request);
    }

    public function handle($builder, Closure $next) : Builder
    {
        if ($this->request->has('created_at') && $this->request->filled('created_at')) {
            $createdAt = collect(json_decode($this->request->input('created_at', '')));
            if ($createdAt && $createdAt->get('start_at') && $createdAt->get('end_at')) {
                $builder =  $builder->whereBetween('created_at', [$createdAt->get('start_at'), $createdAt->get('end_at')]);
            }
        }
        return $next($builder);
    }
}
