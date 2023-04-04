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

    public function validate(?string $authorizationKey, ?string $type): bool
    {
        $hashedInput = hash('sha3-512', $authorizationKey);

        switch ($type) {
            case "restricted":
                if (!($this->getKeyRestricted() == $hashedInput)) {
                    $this->returnUnauthorizedError();
                }
                return true;
            case "public":
                if (!($this->getKeyPublic() == $hashedInput)) {
                    $this->returnUnauthorizedError();
                }
                return true;
            default:
                $this->returnUnauthorizedError();
        }

    }

    private function getKeyRestricted(): string
    {
        return $this->authKeyRepository->find(1)->getKeyName();
    }

    private function getKeyPublic(): string
    {
        return $this->authKeyRepository->find(2)->getKeyName();
    }

    public function returnUnauthorizedError()
    {
        $accessExceptionData = new ServiceExceptionData(401, 'Access denied.');
        throw new ServiceException($accessExceptionData);
    }
}