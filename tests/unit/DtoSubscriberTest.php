<?php

namespace App\Tests\unit;

use App\DTO\CalculateRequestDTO;
use App\Entity\Clients;
use App\Entity\CreditData;
use App\Entity\PlnCalculationResults;
use App\Event\AfterDtoCreatedEvent;
use App\Tests\ServiceTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;


class DtoSubscriberTest extends ServiceTestCase
{

    /** @test */
    public function a_dto_is_validated_after_it_has_been_created(): void
    {
        $creditData = new CreditData();
        $creditData->setValue(-1000.00);

        $event = new AfterDtoCreatedEvent($creditData);

        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->container->get('debug.event_dispatcher');

        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessage('This value should be positive.');

        $eventDispatcher->dispatch($event, $event::NAME);
    }


}