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

    public function validate(string $authorizationKey): bool
    {
        $hashedInput = hash('sha3-512', $authorizationKey);

        if (!($this->getKey() == $hashedInput)) {
            $accessExceptionData = new ServiceExceptionData(403, 'Access denied.: ' . $hashedInput . ' ' . $authorizationKey);
            throw new ServiceException($accessExceptionData);
        }
        return true;
    }

    private function getKey(): string
    {
        return $this->authKeyRepository->find(1)->getKeyName();
    }
}