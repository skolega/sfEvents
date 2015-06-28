<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Score;

class LoadScoreData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 11;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');

        for ($j = 0; $j < 200; $j++) {

            $event = $this->getReference('event' . $j);

            $teams = $event->getTeams();
            $games = $event->getGames();
            
            foreach ($games as $game) {
                foreach ($teams as $team) {
                    $score = new Score();
                    $score->setScore($faker->numberBetween(1, 12));
                    $score->addTeam($team);
                    $score->setGame($game);
                    $this->setReference('score'.$j, $score);
                    $manager->persist($score);
                }
            }
        }
        $manager->flush();
    }

}
