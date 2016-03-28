<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Place;

class LoadPlaceData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 10;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');
        for ($i = 1; $i <= 200; $i++) {

            $place = new Place();
            $place->setName($faker->colorName);
            $place->setCity($faker->city);
            $place->setAddress($faker->address);
            $place->setTelephoneNb($faker->phoneNumber);
            $place->setEnabled(true);
            $place->setDateAdded($faker->dateTimeThisYear('now'));
            $place->addAdmin($this->getReference('user_' . $faker->numberBetween(1, 101)));
            $place->setMaxCapacity($faker->numberBetween(20, 60));
            $place->setPrice($faker->numberBetween(40, 120));
            $place->setFeatured(false);
            $place->setDescription($faker->sentence($faker->numberBetween(10, 40)));
            $place->addCategory($this->getReference('category' . $faker->numberBetween(1, 11)));
            $place->setImageName('http://lorempixel.com/400/200/city/' . $faker->numberBetween(1, 10));
            $this->setReference('place' . $i, $place);
            $manager->persist($place);
        }
        $manager->flush();
    }

}
