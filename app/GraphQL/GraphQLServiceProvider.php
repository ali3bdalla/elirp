<?php

    namespace App\GraphQL;

    use App\Enums\AccountGroupEnum;
    use App\Enums\AccountingTypeEnum;
    use App\Enums\AccountSlugsEnum;
    use GraphQL\Type\Definition\EnumType;
    use Illuminate\Support\ServiceProvider;
    use Nuwave\Lighthouse\Schema\TypeRegistry;
    use Nuwave\Lighthouse\Schema\Types\LaravelEnumType;

    class GraphQLServiceProvider extends ServiceProvider
    {
        /**
         * Bootstrap any application services.
         *
         * @param  \Nuwave\Lighthouse\Schema\TypeRegistry  $typeRegistry
         * @return void
         */
        public function boot(TypeRegistry $typeRegistry) : void
        {
            $this->registryEnums($typeRegistry);
//            $typeRegistry->register(
//                new LaravelEnumType(AccountingTypeEnum::class)
//            );
//            $typeRegistry->register(
//                new LaravelEnumType(AccountGroupEnum::class)
//            );   $typeRegistry->register(
//                new LaravelEnumType(AccountSlugsEnum::class)
//            );
        }

        private function registryEnums(TypeRegistry $typeRegistry)
        {
            $enums = AccountingTypeEnum::toArray();
            $typeRegistry->register(new EnumType([
                'name'   => 'AccountingTypeEnum',
                'values' => $enums
            ]));
        }
    }
