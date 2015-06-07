<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFriendData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 6;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');

        for ($j = 1; $j <= 101; $j++) {
            $user = $this->getReference('user_' . $j);
            $user->addMyFriend($this->getReference('user_' . $faker->numberBetween(1, 10), $user));
            $user->addMyFriend($this->getReference('user_' . $faker->numberBetween(11, 20), $user));
            $user->addMyFriend($this->getReference('user_' . $faker->numberBetween(21, 30), $user));
            $user->addMyFriend($this->getReference('user_' . $faker->numberBetween(31, 40), $user));
            $user->addMyFriend($this->getReference('user_' . $faker->numberBetween(41, 50), $user));
            $user->addMyFriend($this->getReference('user_' . $faker->numberBetween(51, 60), $user));
            $user->addMyFriend($this->getReference('user_' . $faker->numberBetween(61, 70), $user));
            $user->addMyFriend($this->getReference('user_' . $faker->numberBetween(71, 80), $user));
            $user->addMyFriend($this->getReference('user_' . $faker->numberBetween(81, 90), $user));
            $user->addMyFriend($this->getReference('user_' . $faker->numberBetween(91, 101), $user));
        }

        $manager->flush();
    }

}
