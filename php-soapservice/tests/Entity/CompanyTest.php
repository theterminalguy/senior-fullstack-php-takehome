<?php

namespace Application\Tests\Entity;

use Application\Entity\Company;
use Application\Exception\RecordNotFoundException;
use Application\Tests\ActiveRecordArrayDataSet;
use Application\Tests\ActiveRecordTestCase;

use Faker\Factory;

class CompanyTest extends ActiveRecordTestCase
{
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    public function getDataSet()
    {
        return new ActiveRecordArrayDataSet([
            'companies' => [
                [
                    'id' => 1,
                    'name' => $this->faker->company,
                    'email' => $this->faker->companyEmail,
                    'logo_url' => $this->faker->imageUrl(),
                    'address' => $this->faker->address,
                    'country' => $this->faker->country,
                    'tax_rate' => $this->faker->randomFloat(2, 1, 100),
                ]
            ]
        ]);
    }

    public function testSaveCreates()
    {
        $company = new Company($this->getConnection());
        $company->name = $this->faker->company;
        $company->email = $this->faker->companyEmail;
        $company->logo_url = $this->faker->imageUrl();
        $company->address = $this->faker->address;
        $company->country = $this->faker->country;
        $company->tax_rate = $this->faker->randomFloat(2, 1, 100);

        $company->save();

        $this->assertNotNull($company->id);
    }

    public function testSaveUpdates()
    {
        $company = new Company($this->getConnection());

        $default_updated_at = $company->updated_at;
        $default_country = $this->faker->country;
        $default_address = $this->faker->address;

        $company->name = $this->faker->company;
        $company->email = $this->faker->companyEmail;
        $company->logo_url = $this->faker->imageUrl();
        $company->address = $default_address;
        $company->country = $default_country;
        $company->tax_rate = $this->faker->randomFloat(2, 1, 100);

        $company->save();

        $company->country = '10HL Country';
        $company->address = '10HL St. Ives';

        $company->save();

        $this->assertNotEquals($company->country, $default_country);
        $this->assertNotEquals($company->address, $default_address);
        $this->assertNotEquals($company->updated_at, $default_updated_at);
    }

    public function testFind()
    {
        $company = Company::find(1, $this->getConnection());

        $this->assertEquals(1, $company->id);
    }

    public function testFindFails()
    {
        $this->expectException(RecordNotFoundException::class);
        Company::find(-1, $this->getConnection());
    }

    public function testCompanyFullAddress()
    {
        $this->markTestIncomplete("Please write this test");
    }
}
