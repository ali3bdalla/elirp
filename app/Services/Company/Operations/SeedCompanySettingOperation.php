<?php

namespace App\Services\Company\Operations;

use App\Domains\Company\Jobs\UploadCompanyLogoJob;
use App\Models\Company;
use Illuminate\Http\Request;
use Lucid\Units\Operation;

class SeedCompanySettingOperation extends Operation
{
    private Company $company;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        //
        $this->company = $company;
    }

    /**
     * Execute the operation.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        setting()->setExtraColumns(['company_id' => $this->company->id]);

        $companyLogo = $this->run(UploadCompanyLogoJob::class, [
            'company' => $this->company
        ]);
        if ($companyLogo) {
            setting()->set('company.logo', $companyLogo->id);
        }

        $offline_payments = [
            [
                'code' => 'payments.cash.1',
                'name' => trans('demo.offline_payments.cash'),
                'customer' => '0',
                'order' => '1',
                'description' => null,
            ],
            [
                'code' => 'payments.bank_transfer.2',
                'name' => trans('demo.offline_payments.bank'),
                'customer' => '0',
                'order' => '2',
                'description' => null,
            ],
        ];
        // Create settings
        setting()->set([
            'company.name' => $request->get('company_name'),
            'company.email' => $request->get('company_email'),
            'company.tax_number' => $request->get('tax_number'),
            'company.phone' => $request->get('phone'),
            'company.address' => $request->get('address'),
            'default.currency' => 'SAR',
            'default.locale' => $this->company->locale,
            'invoice.title' => trans_choice('general.invoices', 1),
            'wizard.completed' => '1',
            'offline-payments.methods' => json_encode($offline_payments),
        ]);

        if (!empty($request->settings)) {
            foreach ($request->settings as $name => $value) {
                setting()->set([$name => $value]);
            }
        }

        setting()->save();
    }
}
