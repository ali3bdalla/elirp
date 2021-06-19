<?php

    namespace App\Services\DataGrid\Operations;

    use App\Domains\DataGrid\Jobs\CreatedAtFilterJob;
    use App\Domains\DataGrid\Jobs\CreatedByFilterJob;
    use App\Domains\DataGrid\Jobs\SortedByFilterJob;
    use App\Domains\DataGrid\Jobs\ValidateDataGridJob;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Pipeline\Pipeline;
    use Lucid\Units\Operation;

    class GetDataGridQueryOperation extends Operation
    {
        /**
         * @var mixed
         */
        private $request;
        private Builder $builder;
        private array $additionalFilters;

        /**
         * Create a new operation instance.
         *
         * @return void
         */
        public function __construct($request, Builder $builder, $additionalFilters = [])
        {
            $this->request           = parse_request_instance($request);
            $this->builder           = $builder;
            $this->additionalFilters = $additionalFilters;
        }

        /**
         * Execute the operation.
         *
         * @return Builder
         */
        public function handle() : ?Builder
        {
            $this->run(ValidateDataGridJob::class, ['request' => $this->request]);
            return app(Pipeline::class)->through(array_merge([
                new CreatedAtFilterJob($this->request),
                new CreatedByFilterJob($this->request),
                new SortedByFilterJob($this->request),
            ], $this->additionalFilters))->send($this->builder)->thenReturn();

            //                    CreatedByFilter::class,
            //                    new SortByFilter($this->builder->getModel()->getTable())
        }
    }