<?php

namespace App\GraphQL\Directives;

use \Nuwave\Lighthouse\Scout\ScoutBuilderDirective;
use Laravel\Scout\Builder as ScoutBuilder;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;

class WhereInSearchDirective extends BaseDirective implements ScoutBuilderDirective
{
    /**
     * Formal directive specification in schema definition language (SDL).
     *
     * @return string
     */
    public static function definition() : string
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

    public function handleScoutBuilder(ScoutBuilder $builder, $value) : ScoutBuilder
    {
        if ($value != null) {
            return $builder->where($this->directiveArgValue('key', $this->nodeName()), $value);
        }
        return $builder;
    }
}
