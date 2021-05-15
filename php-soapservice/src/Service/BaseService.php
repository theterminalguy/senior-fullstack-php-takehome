<?php

namespace Application\Service;

class BaseService
{
    public array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }
}
