<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\CategoryType;

class loadCategoryTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');
        
        $typesNames = [
            "SPORT",
            "SOCJALNE",
            "ROZRYWKOWE",
            "RUCH I ZDROWIE",
            "RYWALIZACJA",
            "SAMODOSKONALENIE",
            "INNE"
        ];
        
        $i = 1;
        foreach ($typesNames as $name) {
            $categoryType = new CategoryType();
            $categoryType->setName($name);
            $this->addReference('categoryType'. $i++, $categoryType);
            $manager->persist($categoryType);
        }
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

}

