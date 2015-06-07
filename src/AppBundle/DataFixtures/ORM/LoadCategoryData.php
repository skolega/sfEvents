<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class loadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categoriesNames = [
            "Piłka Nożna",
            "Siatkówka",
            "Rolki",
            "Bieganie",
            "Rower",
            "Ognisko",
            "Piłka Ręczna",
            "Koszykówka",
            "Siłownia",
            "Basen",
            "Tenis",
            "Inne"
        ];
        
        $i = 1;
        foreach ($categoriesNames as $name) {
            $category = new Category();
            $category->setName($name);
            $category->setIcon('http://lorempixel.com/200/200/sports/'.$i);
            $this->addReference('category'. $i++, $category);
            $manager->persist($category);
        }
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

}

