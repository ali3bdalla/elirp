<?php

namespace App\Services\Bill\Features;


use App\Domains\Bill\Jobs\ValidateReceiableBillJob;
use App\Domains\Document\Jobs\ChangeDocumentStatusJob;
use App\Domains\Document\Jobs\StoreDocumentHistoryJob;
use App\Enums\DocumentStatusEnum;
use App\Enums\DocumentTypeEnum;
use App\Events\Bill\BillHasBeenMarkedAsReceivedEvent;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Lucid\Units\Feature;

class MarkBillAsReceivedFeature extends Feature
{
    private Document $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function handle(Request $request): RedirectResponse
    {
        $this->run(ValidateReceiableBillJob::class, [
            'document' => $this->document
        ]);
        $this->run(ChangeDocumentStatusJob::class, [
            'document' => $this->document,
            'documentStatusEnum' => DocumentStatusEnum::received()
        ]);

        $type_text = '';
        if ($alias = config('type.' . DocumentTypeEnum::bill()->__toString() . '.alias', '')) {
            $type_text .= $alias . '::';
        }
        $type_text .= 'general.' . config('type.' . DocumentTypeEnum::bill()->__toString() . '.translation.prefix');
        $type = trans_choice($type_text, 1);
        $this->run(StoreDocumentHistoryJob::class, [
            'document' => $this->document->fresh(),
            'notify' => 0,
            trans('documents.messages.marked_received', ['type' => $type])
        ]);

        event(new BillHasBeenMarkedAsReceivedEvent($this->document));
        $message = trans('documents.messages.marked_received', ['type' => trans_choice('general.bills', 1)]);
        flash($message)->success();
        return redirect()->back();
    }
}
