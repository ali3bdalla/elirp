<?php

    namespace App\Domains\DataGrid\Jobs;

    use Closure;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\Schema;
    use Lucid\Units\Job;

    class CreatedByFilterJob extends Job
    {
        private $request;

        public function __construct($request)
        {
            $this->request = parse_request_instance($request);
        }

        public function handle($builder, Closure $next) : Builder
        {
            if ($this->request->has('created_by_id') && $this->request->filled('created_by_id') && is_numeric($this->request->input('created_by_id'))) {
                if (Schema::hasColumn($builder->getModel()->getTable(), 'created_by_id')) {
                    $builder = $builder->where('created_by_id', $this->request->input('created_by_id'));
                }
            }
            return $next($builder);
        }
    }
