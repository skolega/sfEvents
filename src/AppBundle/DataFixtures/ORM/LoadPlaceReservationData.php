<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PlaceReservation;

class LoadPlaceReservationData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 11;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');
        for ($i = 1; $i <= 1500; $i++) {

            $placeReservation = new PlaceReservation();
            $placeReservation->setData($faker->dateTimeBetween('now', '+1 months'));
            $placeReservation->setRepeatable($faker->randomElement([true, false]));
            $placeReservation->setStatus($faker->randomElement([1,2,3]));
            $placeReservation->setType($faker->randomElement([1,2]));
            $placeReservation->setReservedBy($this->getReference('user_'.$faker->numberBetween(1,100)));
            $placeReservation->setPlace($this->getReference('place'.$faker->numberBetween(1,200)));
            $this->setReference('placeReservation' . $i, $placeReservation);
            $manager->persist($placeReservation);
        }
        $manager->flush();
    }

}
