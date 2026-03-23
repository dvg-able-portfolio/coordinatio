<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\Service;
use App\Entity\ServiceCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CrudFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['dev'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadDepartments($manager);
        $this->loadCategories($manager);
        $this->loadServices($manager);
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
}
