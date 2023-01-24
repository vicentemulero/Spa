<?php declare(strict_types=1);

namespace App\Tests\Unit\SpaService\Domain;


use App\SpaServices\Domain\Events\ServiceCreatedEvent;
use App\SpaServices\Domain\Model\Service;
use App\SpaServices\Domain\Model\ServiceSchedule;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

final class ServiceTest extends TestCase
{

    private Service $service;

    protected function setUp(): void
    {
        $this->service = ServiceMother::create();
    }

    /** @test */
    public function given_a_valid_service_when_creating_model_by_named_constructor_then_is_successful(): void
    {
        // Assert
        $this->assertInstanceOf(Service::class, $this->service);
        $this->assertNotNull($this->service->id());
        $this->assertNotNull($this->service->name());
        $this->assertNotNull($this->service->price());
        $this->assertNotNull($this->service->createdAt());
        $this->assertInstanceOf(DateTime::class, $this->service->createdAt());
        $this->assertInstanceOf(ArrayCollection::class, $this->service->serviceSchedules());
        $this->assertInstanceOf(ArrayCollection::class, $this->service->serviceReservations());

        $events = $this->service->pullDomainEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(ServiceCreatedEvent::class, $events[0]);
    }

    /** @test */
    public function given_a_service_when_add_serviceSchedules_are_called_then_the_schedules_should_be_added_with_correct_values(): void
    {

        $date = new DateTime('now');

        $dayAvailable = DateTime::createFromFormat("d/m/Y", $date->format('d/m/y'));
        $availableFrom = DateTime::createFromFormat("H:i", $date->format('H:i'));
        $availableTo = DateTime::createFromFormat("H:i", $date->modify('+3 hour')->format("H:i"));
        $lastTimeAvailable= $availableTo;

        $this->service->addServiceSchedules($dayAvailable, $availableFrom, $availableTo);

        $schedules = $this->service->serviceSchedules();
        $this->assertCount(3, $schedules);

        $firstSchedule = $schedules->first();
        $this->assertInstanceOf(ServiceSchedule::class, $firstSchedule);
        $this->assertEquals($dayAvailable->format('d/m/Y'), $firstSchedule->dayAvailable());
        $this->assertEquals($availableFrom->format('H:i'), $firstSchedule->availableFrom());
        $this->assertEquals($availableTo->format('H:i'), $firstSchedule->availableTo());
        $this->assertEquals($availableFrom->format('H:i'), $firstSchedule->availableTime());

        $lastSchedule = $schedules->last();
        $this->assertInstanceOf(ServiceSchedule::class, $lastSchedule);
        $this->assertEquals($dayAvailable->format('d/m/Y'), $lastSchedule->dayAvailable());
        $this->assertEquals($availableFrom->format('H:i'), $lastSchedule->availableFrom());
        $this->assertEquals($availableTo->format('H:i'), $lastSchedule->availableTo());
        $this->assertEquals($lastTimeAvailable->modify('-1 hour')->format('H:i'), $lastSchedule->availableTime());

    }

}
