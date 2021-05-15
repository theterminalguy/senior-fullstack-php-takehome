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

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo_url' => $this->logo_url,
            'tax_rate' => $this->tax_rate,
            'address' => $this->fullAddress()
        ];
    }
}
