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
        $faker = \Faker\Factory::create('pl_PL');
        
        $categoriesNames = [
            "lightskyblue" =>"Piłka Nożna",
            "aquamarine" =>"Siatkówka",
            "tomato" =>"Rolki",
            "coral" =>"Bieganie",
            "darkcyan" =>"Rower",
            "darkorange" =>"Ognisko",
            "deeppink" =>"Piłka Ręczna",
            "turquoise" =>"Koszykówka",
            "greenyellow" =>"Siłownia",
            "slategray" =>"Basen",
            "lightslategray" =>"Tenis",
            "salmon" =>"Inne"
        ];
        
        $i = 1;
        foreach ($categoriesNames as $key => $name) {
            $category = new Category();
            $category->setName($name);
            $category->setColor($key);
            $category->setCategoryType($this->getReference('categoryType'.$faker->numberBetween(1,7)));
            $category->setIcon('http://lorempixel.com/200/200/sports/'.$i);
            $this->addReference('category'. $i++, $category);
            $manager->persist($category);
        }
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }

}

