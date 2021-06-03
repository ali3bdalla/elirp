<?php

namespace App\Domains\Company\Jobs;

use App\Models\Company;
use App\Models\EmailTemplate;
use Lucid\Units\Job;

class SeedCompanyEmailTemplatesJob extends Job
{
    private Company $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        //
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $templates = [
            [
                'alias' => 'invoice_new_customer',
                'class' => 'App\Notifications\Sale\Invoice',
                'name' => 'settings.email.templates.invoice_new_customer',
            ],
            [
                'alias' => 'invoice_remind_customer',
                'class' => 'App\Notifications\Sale\Invoice',
                'name' => 'settings.email.templates.invoice_remind_customer',
            ],
            [
                'alias' => 'invoice_remind_admin',
                'class' => 'App\Notifications\Sale\Invoice',
                'name' => 'settings.email.templates.invoice_remind_admin',
            ],
            [
                'alias' => 'invoice_recur_customer',
                'class' => 'App\Notifications\Sale\Invoice',
                'name' => 'settings.email.templates.invoice_recur_customer',
            ],
            [
                'alias' => 'invoice_recur_admin',
                'class' => 'App\Notifications\Sale\Invoice',
                'name' => 'settings.email.templates.invoice_recur_admin',
            ],
            [
                'alias' => 'invoice_payment_customer',
                'class' => 'App\Notifications\Portal\PaymentReceived',
                'name' => 'settings.email.templates.invoice_payment_customer',
            ],
            [
                'alias' => 'invoice_payment_admin',
                'class' => 'App\Notifications\Portal\PaymentReceived',
                'name' => 'settings.email.templates.invoice_payment_admin',
            ],
            [
                'alias' => 'bill_remind_admin',
                'class' => 'App\Notifications\Purchase\Bill',
                'name' => 'settings.email.templates.bill_remind_admin',
            ],
            [
                'alias' => 'bill_recur_admin',
                'class' => 'App\Notifications\Purchase\Bill',
                'name' => 'settings.email.templates.bill_recur_admin',
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::create([
                'company_id' => $this->company->id,
                'alias' => $template['alias'],
                'class' => $template['class'],
                'name' => $template['name'],
                'subject' => trans('email_templates.' . $template['alias'] . '.subject'),
                'body' => trans('email_templates.' . $template['alias'] . '.body'),
            ]);
        }
    }
}
