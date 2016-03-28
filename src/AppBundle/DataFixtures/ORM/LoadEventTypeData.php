<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\EventType;

class loadEventTypeData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');

        $typesNames = [
            'Sport płatne drużynowe - zapisy drużynowe publiczne' => [ 1 , 1 , 1 , 1 , 1 ] , 
            'Sport płatne drużynowe - zapisy indywidualne publiczne' => [ 1 , 1 , 1 , 0 , 1 ] , 
            'Wydarzenie płatne drużynowe - zapisy drużynowe publiczne' => [ 0 , 1 , 1 , 1 , 1 ] , 
            'Wydarzenie płatne drużynowe - zapisy indywidualne publiczne' => [ 0 , 1 , 1 , 0 , 1 ] , 
            'Sport płatne drużynowe - zapisy drużynowe prywatne' => [ 1 , 1 , 1 , 1 , 0 ] , 
            'Sport płatne drużynowe - zapisy indywidualne prywatne' => [ 1 , 1 , 1 , 0 , 0 ] , 
            'Wydarzenie płatne drużynowe - zapisy drużynowe prywatne' => [ 0 , 1 , 1 , 1 , 0 ] , 
            'Wydarzenie płatne drużynowe - zapisy indywidualne prywatne' => [ 0 , 1 , 1 , 0 , 0 ] , 
            'Sport drużynowe - zapisy drużynowe publiczne' => [ 1 , 0 , 1 , 1 , 1 ] , 
            'Sport drużynowe - zapisy indywidualne publiczne' => [ 1 , 0 , 1 , 0 , 1 ] , 
            'Wydarzenie drużynowe - zapisy drużynowe publiczne' => [ 0 , 0 , 1 , 1 , 1 ] , 
            'Wydarzenie drużynowe - zapisy indywidualne publiczne' => [ 0 , 0 , 1 , 0 , 1 ] , 
            'Sport drużynowe - zapisy drużynowe prywatne' => [ 1 , 0 , 1 , 1 , 0 ] , 
            'Sport drużynowe - zapisy indywidualne prywatne' => [ 1 , 0 , 1 , 0 , 0 ] , 
            'Wydarzenie drużynowe - zapisy drużynowe prywatne' => [ 0 , 0 , 1 , 1 , 0 ] , 
            'Wydarzenie drużynowe - zapisy indywidualne prywatne' => [ 0 , 0 , 1 , 0 , 0 ] , 
            'Sport - zapisy drużynowe publiczne' => [ 1 , 0 , 0 , 1 , 1 ] , 
            'Sport - zapisy indywidualne publiczne' => [ 1 , 0 , 0 , 0 , 1 ] , 
            'Wydarzenie - zapisy drużynowe publiczne' => [ 0 , 0 , 0 , 1 , 1 ] , 
            'Wydarzenie - zapisy indywidualne publiczne' => [ 0 , 0 , 0 , 0 , 1 ] , 
            'Sport - zapisy drużynowe prywatne' => [ 1 , 0 , 0 , 1 , 0 ] , 
            'Sport - zapisy indywidualne prywatne' => [ 1 , 0 , 0 , 0 , 0 ] , 
            'Wydarzenie - zapisy drużynowe prywatne' => [ 0 , 0 , 0 , 1 , 0 ] , 
            'Wydarzenie - zapisy indywidualne prywatne' => [ 0 , 0 , 0 , 0 , 0 ] , 
            'Sport płatne - zapisy drużynowe publiczne' => [ 1 , 1 , 0 , 1 , 1 ] , 
            'Sport płatne - zapisy indywidualne publiczne' => [ 1 , 1 , 0 , 0 , 1 ] , 
            'Wydarzenie płatne - zapisy drużynowe publiczne' => [ 0 , 1 , 0 , 1 , 1 ] , 
            'Wydarzenie płatne - zapisy indywidualne publiczne' => [ 0 , 1 , 0 , 0 , 1 ] , 
            'Sport płatne - zapisy drużynowe prywatne' => [ 1 , 1 , 0 , 1 , 0 ] , 
            'Sport płatne - zapisy indywidualne prywatne' => [ 1 , 1 , 0 , 0 , 0 ] , 
            'Wydarzenie płatne - zapisy drużynowe prywatne' => [ 0 , 1 , 0 , 1 , 0 ] , 
            'Wydarzenie płatne - zapisy indywidualne prywatne' => [ 0 , 1 , 0 , 0 , 0 ] ,
        ];
        $i = 1;
        foreach ($typesNames as $name => $options) {
            $eventType = new EventType();
            $eventType->setName($name);
            $eventType->setDescription($faker->sentence($faker->numberBetween(4, 12)));
            $eventType->setEnabled(true);
            $eventType->setPayable($options[1]);
            $eventType->setPlayable($options[0]);
            $eventType->setPublic($options[4]);
            $eventType->setTeamable($options[3]);
            $eventType->setTwoTeams($options[2]);
            $this->addReference('eventType' . $i++, $eventType);
            $manager->persist($eventType);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }

}
