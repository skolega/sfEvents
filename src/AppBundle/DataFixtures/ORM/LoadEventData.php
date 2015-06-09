<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Event;

class LoadEventData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 4;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');

        for ($j = 0; $j < 200; $j++) {
            $administrator = $this->getReference('user_' . $faker->numberBetween(20, 101));
            $event = new Event();
            $randNumber = $faker->numberBetween(1, 12);
            $event->setName($faker->sentence(2));
            $event->setLoacation($faker->streetAddress);
            $event->setCreatedAt($faker->dateTimeThisYear($max = 'now'));
            $event->setStartDate($faker->dateTimeThisYear($max = 'now'));
            $event->setEndDate($faker->dateTimeThisYear($max = 'now'));
            $event->setEnabled(true);
            $event->setImage('http://lorempixel.com/200/130/sports/' . $randNumber);
            $event->setCity($faker->city);
            $event->setFeatured(false);
            $event->setType($faker->numberBetween(1,3));
            $event->addTeam($this->getReference('team'. $faker->numberBetween(1, 19)));
            $event->addTeam($this->getReference('team'. $faker->numberBetween(20, 40)));
            $event->addPlayer($administrator);
            $event->setDescription($faker->sentence(15));
            $event->setCategory($this->getReference('category' . $randNumber));
            $event->setAdmin($administrator);
            $event->setCapacity($faker->numberBetween(5, 20));
            for($i=1;$i<$faker->numberBetween(1, 19);$i++){
                $event->addPlayer($this->getReference('user_' . $i));
            }
            $this->setReference('event' . $j, $event);
            $manager->persist($event);
        }

        $manager->flush();
    }

}
