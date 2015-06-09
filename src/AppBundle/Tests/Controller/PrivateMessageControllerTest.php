<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PrivateMessageControllerTest extends WebTestCase
{
    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new/privatemessage');
    }

    public function testRemove()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/remove/privatemessage');
    }

    public function testReply()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'reply/privatemessage');
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/show/privatemessage');
    }

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/list/privatemessage');
    }

}
