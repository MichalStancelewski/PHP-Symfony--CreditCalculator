<?php

namespace App\Service\Authorization;

use App\Repository\AuthKeyRepository;
use App\Service\ServiceException;
use App\Service\ServiceExceptionData;

class AuthorizationValidation
{
    public function __construct(private AuthKeyRepository $authKeyRepository)
    {
    }

    public function validate(?string $authorizationKey): bool
    {
        $hashedInput = hash('sha3-512', $authorizationKey);

        if (!($this->getKey() == $hashedInput) ) {
            $this->returnUnauthorizedError();
        }
        return true;
    }

    private function getKey(): string
    {
        return $this->authKeyRepository->find(1)->getKeyName();
    }

    public function returnUnauthorizedError(){
        $accessExceptionData = new ServiceExceptionData(401, 'Access denied.');
        throw new ServiceException($accessExceptionData);
    }
}