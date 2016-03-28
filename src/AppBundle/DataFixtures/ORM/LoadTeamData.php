<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Team;

class LoadTeamData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 4;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');

        for ($j = 1; $j <= 40; $j++) {
            $team = new Team();
            $team->setName($faker->colorName());
            $team->setType($faker->numberBetween(1,3));
            $team->setUpdatedAt($faker->dateTimeThisYear);
            $this->addReference('team' . $j, $team);
            $team->setImageName('http://lorempixel.com/20/20/abstract/'.$faker->numberBetween(1,10));
            $manager->persist($team);
        }

        $manager->flush();
    }

}
