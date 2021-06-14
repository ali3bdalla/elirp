<?php

namespace App\Domains\DataGrid\Jobs;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Lucid\Units\Job;

class SortedByFilterJob extends Job
{
    private $request;

    public function __construct($request)
    {
        $this->request = parse_request_instance($request);
    }

    public function handle($request, Closure $next) : Builder
    {
//        $request = parse_request_instance ($request);
//        if ($request->has ('created_by_id') && $request->filled ('created_by_id') && is_numeric ($request->input ('created_by_id'))) {
//            $builder = $next($request);
//            return $builder->where ('created_by_id', $request->input ('created_by_id'));
//        }
        return $next($request);
    }
}
