<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testAddfriend()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add/{id}');
    }

    public function testDeletefriend()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/delete/friend/{id}');
    }

    public function testSendmessage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'send/user/{id}');
    }

}
