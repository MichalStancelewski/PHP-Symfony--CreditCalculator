<?php

namespace App\Tests\unit;

use App\Entity\CreditData;
use App\Event\AfterDtoCreatedEvent;
use App\EventSubscriber\DtoSubscriber;
use App\Service\ServiceException;
use App\Tests\ServiceTestCase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;


class DtoSubscriberTest extends ServiceTestCase
{

    /** @test */
    public function testEventSubscription(): void
    {
        $this->assertArrayHasKey(AfterDtoCreatedEvent::NAME, DtoSubscriber::getSubscribedEvents());
    }

    /** @test */
    public function a_dto_is_validated_after_it_has_been_created(): void
    {
        $creditData = new CreditData();
        $creditData->setValue(-1000.00);

        $event = new AfterDtoCreatedEvent($creditData);

        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->container->get('debug.event_dispatcher');

        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('Validation failed');

        $eventDispatcher->dispatch($event, $event::NAME);
    }


}