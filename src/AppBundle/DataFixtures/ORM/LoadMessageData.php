<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Message;

class LoadMessageData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 5;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');
        
        for($i=1; $i < 500 ; $i++){
            $message = new Message();
            $message->setMessage($faker->sentence($faker->numberBetween(1, 10)));
            $message->setCreatedAt($faker->dateTimeThisYear($max = 'now'));
            $message->setCreatedBy($this->getReference('user_' . $faker->numberBetween(1, 101)));
            $message->setEvent($this->getReference('event'. $faker->numberBetween(1, 199)));
            $this->setReference('message'.$i, $message);
            $manager->persist($message);
        }
        $manager->flush();
    }

}
