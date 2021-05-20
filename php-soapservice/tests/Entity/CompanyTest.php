<?php

namespace Application\Tests\Entity;

use Application\Entity\ActiveRecord;
use DateTime;

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

        ActiveRecord::$db_conn = $this->getConnection();
    }

    public function getDataSet()
    {
        $current_datetime = (new DateTime())->format('Y-m-d H:i:s');

        return new ActiveRecordArrayDataSet([
            'companies' => [
                [
                    'id' => 1,
                    'created_at' => $current_datetime,
                    'updated_at' => $current_datetime,
                    'name' => 'Helping Hands Residential Cleaning Services',
                    'email' => 'hello@helpinghands.com',
                    'logo_url' => 'https://bit.ly/2RRNEyC',
                    'address' => '15 Westmount Rd S Unit 102, Waterloo, ON N2L 2K2',
                    'country' => 'Canada',
                    'tax_rate' => 14.72,
                ]
            ]
        ]);
    }

    public function testSaveCreates()
    {
        $company = new Company();
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
        $company = new Company();

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
        $company = Company::find(1);

        $this->assertEquals(1, $company->id);
    }

    public function testFindFails()
    {
        $this->expectException(RecordNotFoundException::class);
        Company::find(-1);
    }

    public function testDelete()
    {
        $company = new Company();
        $company->name = $this->faker->company;
        $company->email = $this->faker->companyEmail;
        $company->logo_url = $this->faker->imageUrl();
        $company->address = $this->faker->address;
        $company->country = $this->faker->country;
        $company->tax_rate = $this->faker->randomFloat(2, 1, 100);

        $company->save();

        Company::delete($company->id);

        $this->expectException(RecordNotFoundException::class);
        Company::find($company->id);
    }

    public function testCompanyFullAddress()
    {
        $this->markTestIncomplete("Please write this test");
    }
}
