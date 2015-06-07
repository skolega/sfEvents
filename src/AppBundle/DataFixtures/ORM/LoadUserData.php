<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');

        for ($j = 1; $j <= 100; $j++) {
            $user = new User();
            $user->setUsername('user' . $j);
            $user->setEmail($faker->email);
            $user->setPlainPassword('user');
            $user->setName($faker->word);
            $user->setSurname($faker->word);
            $user->setEnabled(true);
            $user->setPreferedCity($faker->city);
            $user->setImageName('http://lorempixel.com/80/80/people/' . $faker->numberBetween(1, 10));
            $user->setPoints($faker->numberBetween(1, 10000));
            $this->addReference('user_' . $j, $user);
            $manager->persist($user);
        }

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail($faker->email);
        $user->setName($faker->word);
        $user->setSurname($faker->word);
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $user->setPreferedCity($faker->city);
        $user->addRole('ROLE_ADMIN');
        $user->setImageName('http://lorempixel.com/80/80/people/' . $faker->numberBetween(1, 10));
        $user->setPoints($faker->numberBetween(1, 10000));
        $this->addReference('user_101', $user);
        $manager->persist($user);
        

        $manager->flush();
    }

}
