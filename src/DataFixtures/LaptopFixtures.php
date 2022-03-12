<?php

namespace App\DataFixtures;

use App\Entity\Laptop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LaptopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=30; $i++)
        {
            $laptop = new Laptop;
            $laptop->setName("Laptop $i");
            $laptop->setBrand("HP");
            $laptop->setPrice(100);
            $laptop->setColor("Gold");
            $manager->persist($laptop);
        }
        $manager->flush();
    }
}
