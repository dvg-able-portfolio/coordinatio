<?php

declare(strict_types=1);

namespace App\Tests\Controller\Crud;

use App\Entity\Guest;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Panther\PantherTestCase;

final class GuestControllerTest extends PantherTestCase
{
    private EntityManagerInterface $manager;
    private EntityRepository $guestRepository;
    private string $path = '/crud/guest/';

    protected function setUp(): void
    {
        static::createPantherClient(); // boot Panther first

        $this->manager = static::getContainer()
            ->get('doctrine')
            ->getManager();

        $this->guestRepository = $this->manager->getRepository(Guest::class);

        foreach ($this->guestRepository->findAll() as $object) {
            $this->manager->remove($object);
        }
        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $client = static::createPantherClient();

        $client->request('GET', $this->path);

        self::assertSelectorTextContains('[data-test="guest-index"]', 'Guests');
    }

    public function testNew(): void
    {

        self::assertSame(0, $this->guestRepository->count([]));

        $client = static::createPantherClient([
            'browser' => PantherTestCase::CHROME,
        ]);

        $crawler = $client->request('GET', $this->path . 'new');

        //todo How do we inject this corrrectly in ->form()
        $client->executeScript("document.querySelector('#guest_checked_in_at').value = '2026-03-26T12:00:00'");

        $form = $crawler->filter('[data-test="crud-form-submit-btn"]')->form([
            'guest[name]' => 'Testing',
            'guest[room_number]' => '101',
            'guest[session_token]' => '123456',
            //'guest[checked_in_at]' => '2026-03-26 12:00',
        ]);

        $client->submit($form);

        $crawler = $client->waitFor('[data-test="guest-index"]', 5);

        self::assertSelectorTextContains('table.table tbody tr td:nth-child(2)', 'Testing');

        self::assertSame(1, $this->guestRepository->count([]));
    }

    public function testShow(): void
    {
        $fixture = new Guest();
        $fixture->setName('John Doe');
        $fixture->setRoomNumber('101');
        $fixture->setSessionToken('abc123');
        $fixture->setCheckedInAt(new DateTime('2026-03-26 12:00:00'));
        $fixture->setCheckOutAt(new DateTime('2026-03-27 12:00:00'));
        $this->manager->persist($fixture);
        $this->manager->flush();

        $client = static::createPantherClient();
        $client->request('GET', $this->path . $fixture->getId());

        self::assertSelectorWillExist('[data-test="guest-show"]');
        self::assertSelectorTextContains('[data-test="guest-name"]', 'John Doe');
    }

    public function testEdit(): void
    {
        $fixture = new Guest();
        $fixture->setName('Old Name');
        $fixture->setRoomNumber('101');
        $fixture->setSessionToken('123456');
        $fixture->setCheckedInAt(new DateTime('2026-03-26 12:00:00'));
        $fixture->setCheckOutAt(new DateTime('2026-03-27 12:00:00'));
        $this->manager->persist($fixture);
        $this->manager->flush();

        $client = static::createPantherClient();
        $crawler = $client->request('GET', $this->path . $fixture->getId() . '/edit');

        $form = $crawler->filter('[data-test="crud-form-submit-btn"]')->form([
            'guest[name]' => 'New Name',
        ]);
        $client->submit($form);

        $client->waitFor('[data-test="guest-index"]', 5);

        $row = $crawler->filter('.table tbody tr')->reduce(function ($node) use ($fixture) {
            return str_contains($node->filter('td')->eq(0)->text(), (string) $fixture->getId());
        });

        self::assertSame('New Name', $row->filter('td')->eq(1)->text());
    }

    public function testRemove(): void
    {
        $fixture = new Guest();
        $fixture->setName('To Delete');
        $fixture->setRoomNumber('101');
        $fixture->setSessionToken('123456');
        $fixture->setCheckedInAt(new DateTime('2026-03-26 12:00:00'));
        $fixture->setCheckOutAt(new DateTime('2026-03-27 12:00:00'));
        $this->manager->persist($fixture);
        $this->manager->flush();

        $client = static::createPantherClient();

        $crawler = $client->request('GET', $this->path . $fixture->getId());

        $crawler->filter('[data-test="crud-form-delete-btn"]')->click();

        $client->getWebDriver()->switchTo()->alert()->accept();

        $client->waitFor('[data-test="guest-index"]', 5);

        self::assertSame(0, $this->guestRepository->count([]));
    }
}
