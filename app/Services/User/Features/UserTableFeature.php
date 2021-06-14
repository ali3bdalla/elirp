<?php

    namespace App\Services\User\Features;

    use App\Models\User;
    use App\Services\DataGrid\Operations\GetDataGridQueryOperation;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Lucid\Units\Feature;

    class UserTableFeature extends Feature
    {
        public function handle(Request $request)
        {
            $builder = $this->run(GetDataGridQueryOperation::class, ['request' => $request, 'builder' => User::query()]);
            return new Response($builder->paginate(100));
        }
    }
