<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\Item;
use App\Models\User;
use App\Services\Document\Features\MarkDocumentAsPaidFeature;
use App\Services\Document\Features\MarkDocumentAsRefundedFeature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Lucid\Bus\ServesFeatures;

class DatabaseSeeder extends Seeder
{
    use ServesFeatures;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::get();
        foreach ($companies as $company) {
            Auth::guard('web')->login($company->users()->first());
//            User::factory(['company_id' =>   $company->id])->count(10)->create();
//            Item::factory(['company_id' => $company->id])->count(10)->create();
//            Contact::factory(['company_id' => $company->id])->count(10)->create();
            $documents = Document::factory(['company_id' => $company->id])->bill()->count(25)->create();
            foreach ($documents as $document) {
                DocumentItem::factory([
                    'document_id' => $document->id,
                    'company_id'  => $document->company_id,
                    'type'        => $document->type,
                ])->count(5)->create();
                $this->serve(MarkDocumentAsPaidFeature::class, [
                    'document' => $document
                ]);
                $this->serve(MarkDocumentAsRefundedFeature::class, [
                    'document' => $document
                ]);
            }
            $documents = Document::factory(['company_id' => $company->id])->invoice()->count(25)->create();

            foreach ($documents as $document) {
                DocumentItem::factory([
                    'document_id' => $document->id,
                    'company_id'  => $document->company_id,
                    'type'        => $document->type,
                ])->count(5)->create();
                $this->serve(MarkDocumentAsPaidFeature::class, [
                    'document' => $document
                ]);
                $this->serve(MarkDocumentAsRefundedFeature::class, [
                    'document' => $document
                ]);
            }
//            Document::factory(['company_id' => $company->id])->invoice()->count(50)->create();
            // dd(Company::factory()->disabledFactoryState()->create());
            // \App\Models\User::factory(10)->create();
        }
    }
}
