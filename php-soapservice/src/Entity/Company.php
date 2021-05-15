<?php

namespace Application\Entity;
class Company extends ActiveRecord
{
    const TABLE_NAME = 'companies';

    public string $name;

    public string $email;

    public string $logo_url;

    public string $address;

    public string $country;

    public float $tax_rate;

    public function fullAddress()
    {
        return $this->address . ", " . $this->country;
    }
}
