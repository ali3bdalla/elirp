<?php

namespace App\GraphQL\Directives;

use GraphQL\Language\AST\FieldDefinitionNode;
use GraphQL\Language\AST\InputValueDefinitionNode;
use GraphQL\Language\AST\ObjectTypeDefinitionNode;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgBuilderDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgDirectiveForArray;
use Nuwave\Lighthouse\Support\Contracts\ArgManipulator;
use Nuwave\Lighthouse\Support\Contracts\ArgResolver;
use Nuwave\Lighthouse\Support\Contracts\ArgTransformerDirective;
use \Nuwave\Lighthouse\Scout\ScoutBuilderDirective;
use Laravel\Scout\Builder as ScoutBuilder;

class WhereInSearchDirective extends BaseDirective implements ScoutBuilderDirective
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
        if ($value  != null)
            return $builder->where($this->directiveArgValue('key', $this->nodeName()), $value);
        return $builder;
    }
}
