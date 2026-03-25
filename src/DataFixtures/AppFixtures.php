<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\Employee;
use App\Entity\Guest;
use App\Entity\Service;
use App\Entity\ServiceCategory;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['dev'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadDepartments($manager);
        $this->loadEmployees($manager);
        $this->loadCategories($manager);
        $this->loadServices($manager);
        $this->loadGuests($manager);
    }

    protected function loadDepartments(ObjectManager $manager): void
    {
        $jsonFile = __DIR__ . '/data/departments.json';
        $departments = json_decode(file_get_contents($jsonFile));

        foreach ($departments as $d) {
            $department = new Department();
            $department->setCode($d->code);
            $department->setName($d->name);
            $department->setDescription($d->description);
            $manager->persist($department);
        }

        $manager->flush();
    }

    protected function loadEmployees(ObjectManager $manager): void
    {
        $jsonFile = __DIR__ . '/data/employees.json';
        $employees = json_decode(file_get_contents($jsonFile));


        $departments = $manager->getRepository(Department::class)->findAll();

        $departmentMap = [];
        foreach ($departments as $dept) {
            $departmentMap[$dept->getCode()] = $dept;
        }

        foreach ($employees as $e) {
            $employee = new Employee();
            $employee->setName($e->name);
            $employee->setLoginToken($e->login_token);
            $employee->setRole($e->role);
            if (isset($departmentMap[$e->department_code])) {
                $employee->setDepartment($departmentMap[$e->department_code]);
            }
            $manager->persist($employee);
        }

        $manager->flush();
    }

    protected function loadCategories(ObjectManager $manager): void
    {
        $jsonFile = __DIR__ . '/data/categories.json';
        $categories = json_decode(file_get_contents($jsonFile));

        foreach ($categories as $c) {
            $category = new ServiceCategory();
            $category->setCode($c->code);
            $category->setName($c->name);
            $category->setDescription($c->description);
            $manager->persist($category);
        }

        $manager->flush();
    }

    protected function loadServices(ObjectManager $manager): void
    {
        $jsonFile = __DIR__ . '/data/services.json';
        $services = json_decode(file_get_contents($jsonFile));

        $departments = $manager->getRepository(Department::class)->findAll();
        $categories = $manager->getRepository(ServiceCategory::class)->findAll();

        $departmentMap = [];
        foreach ($departments as $dept) {
            $departmentMap[$dept->getCode()] = $dept;
        }

        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[$cat->getCode()] = $cat;
        }

        foreach ($services as $s) {
            $service = new Service();
            $service->setName($s->name);
            $service->setCode($s->code);
            $service->setDescription($s->description);
            $service->setAvailableFrom($s->available_from);
            $service->setAvailableTo($s->available_to);
            $service->setIsSchedulable($s->is_schedulabe ?? false);
            if (isset($departmentMap[$s->department_code])) {
                $service->setDepartment($departmentMap[$s->department_code]);
            }
            if (!empty($s->category_codes) && is_array($s->category_codes)) {
                foreach ($s->category_codes as $catCode) {
                    if (isset($categoryMap[$catCode])) {
                        $service->addCategory($categoryMap[$catCode]);
                    }
                }
            }
            $manager->persist($service);
        }

        $manager->flush();
    }


    protected function loadGuests(ObjectManager $manager): void
    {
        $jsonFile = __DIR__ . '/data/guests.json';
        $guests = json_decode(file_get_contents($jsonFile));

        foreach ($guests as $g) {
            $guest = new Guest();
            $guest->setName($g->name);
            $guest->setRoomNumber($g->room_number);
            $guest->setSessionToken($g->session_token);
            $guest->setCheckedInAt(new DateTime());
            $manager->persist($guest);
        }

        $manager->flush();
    }
}
