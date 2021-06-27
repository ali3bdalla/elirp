<?php

namespace App\GraphQL\Directives;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgDirective;
use Laravel\Scout\Builder as ScoutBuilder;
use \Nuwave\Lighthouse\Scout\ScoutBuilderDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgTransformerDirective;

class OrderByInSearchDirective extends BaseDirective implements ScoutBuilderDirective
{

    /**
     * Formal directive specification in schema definition language (SDL).
     *
     * @return string
     */
    public static function definition(): string
    {
        return
            /** @lang GraphQL */
            <<<'GRAPHQL'
    """
    A description of what this directive does.
    """
    directive @upperCase(
        """
        Directives can have arguments to parameterize them.
        """
        someArg: String
    ) on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
GRAPHQL;
    }

    public function handleScoutBuilder(ScoutBuilder $builder, $value): ScoutBuilder
    {

        if ($value) {
            $data = collect($value);
            $column = $data->get('column', null);
            $order = $data->get('order', null);
            if (
                $column && $order && in_array(
                    $order,
                    ['asc', 'desc']
                ) && in_array($column, collect($this->directiveArgValue('columns', []))->toArray())
            ) {
                return $builder->orderBy($column, $order);
            }
        }
        return $builder;
    }
}
