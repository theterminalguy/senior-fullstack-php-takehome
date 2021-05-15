<?php

namespace Application\Service;

use Application\Entity\Company;
use Application\Exception\NotImplementedException;
use Application\Exception\RecordNotFoundException;

class CompanyService extends BaseService
{
    public function getCompanyById()
    {
        try {
            return Company::find($this->params['id']);
        } catch (RecordNotFoundException $e) {
            http_response_code(404);
            die($e->getMessage());
        }
    }

    public function getAllCompanies()
    {
        throw new NotImplementedException();
    }
}
