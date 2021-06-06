<?php

namespace Tests\Feature;

use App\Domains\Company\Jobs\SeedCategoriesJob;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Tests\TestCase;

abstract class FeatureTestCase extends TestCase
{
    protected $faker;

    protected $user;

    protected $company;

    /**
     * Empty for default user.
     *
     * @param User|null $user
     * @param Company|null $company
     * @return FeatureTestCase
     */
    public function loginAs(User $user = null, Company $company = null)
    {
        if (! $company) {
            $company = Company::factory()->create();
        }
        if (! $user) {
            $user = User::factory()->enabledFactoryState()->create([
                'company_id' => $company->id
            ]);
        }
        setting()->setExtraColumns(['company_id' => $company->id]);
        setting()->set([
            'company.name'       => $this->faker->company,
            'company.email'      => $this->faker->companyEmail,
            'company.tax_number' => $this->faker->bankAccountNumber,
            'company.phone'      => $this->faker->phoneNumber,
            'company.address'    => $this->faker->address,
            'default.currency'   => 'SAR',
            'default.locale'     => 'ar-SA',
            'wizard.completed'   => '1',
        ]);

        $job = new SeedCategoriesJob($company);
        $job->handle();
        $this->company = $company;
        $this->user    = $user;
        setting()->save();

        return $this->actingAs($user);
    }

    public function assertFlashLevel($excepted)
    {
        $flash['level'] = null;

        if ($flashMessage = session('flash_notification')) {
            $flash = $flashMessage->first();
        }

        $this->assertEquals($excepted, $flash['level']);
    }

    protected function setUp() : void
    {
        parent::setUp();

//        $this->withoutExceptionHandling();

        $this->faker = Faker::create();
        config(['debugbar.enabled', false]);
        Carbon::setTestNow();
    }
}
