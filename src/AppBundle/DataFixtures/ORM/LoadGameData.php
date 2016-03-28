<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Game;

class LoadGaneData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 12;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');

        for ($j = 1; $j <= 500; $j++) {
            $game = new Game();
            $game->setDate($faker->dateTimeThisYear('now'));
            $game->setDescription($faker->sentence($faker->numberBetween(12,44)));
            $game->addEvent($this->getReference('event'. $faker->numberBetween(1,199)));
            $game->setPlayed(true);
            $game->setVerified(true);
            $this->addReference('game' . $j, $game);
            $manager->persist($game);
        }

        $manager->flush();
    }

}
