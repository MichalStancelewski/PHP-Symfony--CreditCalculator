<?php

namespace App\Event;

use App\DTO\CalculationEnquiryInterface;
use App\Entity\EnquiryInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AfterDtoCreatedEvent extends Event
{
    public const NAME = 'dto.created';

    public function __construct(protected EnquiryInterface $dto)
    {
    }

    public function getDto(): EnquiryInterface
    {
        return $this->dto;
    }

}