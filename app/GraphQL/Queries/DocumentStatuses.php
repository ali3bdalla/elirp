<?php

namespace App\GraphQL\Queries;

use App\Enums\DocumentStatusEnum;
use App\Enums\DocumentTypeEnum;

class DocumentStatuses
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $type   = isset($args['type']) && in_array($args['type'], ['BILL', 'INVOICE']) ? $args['type'] : 'BILL';
        $values = DocumentStatusEnum::invoice_statuses();
        if (
            DocumentTypeEnum::from($type)->equals(DocumentTypeEnum::BILL())) {
            $values = DocumentStatusEnum::bill_statuses();
        }
        return DocumentStatusEnum::toOptions($values);
    }
}
