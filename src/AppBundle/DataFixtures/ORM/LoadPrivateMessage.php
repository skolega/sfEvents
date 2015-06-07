<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PrivateMessage;

class LoadPrivateMessageData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 7;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');

        for ($j = 1; $j <= 301; $j++) {
            $privateMessage = new PrivateMessage();
            $privateMessage->setCreatedBy($this->getReference('user_'.$faker->numberBetween(1,101)));
            $privateMessage->setMessage($faker->sentence($faker->numberBetween(3,25)));
            $privateMessage->setSendTo($this->getReference('user_'.$faker->numberBetween(1,101)));
            $privateMessage->setCreatedAt($faker->dateTimeThisYear('now'));
            $privateMessage->setReaded(false);
            $manager->persist($privateMessage);
        }

        $manager->flush();
    }

}
