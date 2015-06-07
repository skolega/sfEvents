<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NotificationControllerTest extends WebTestCase
{
    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add/notification');
    }

    public function testHide()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hide');
    }

    public function testRemove()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/remove/notification');
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/show/notification');
    }

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/list/notifications');
    }

}
