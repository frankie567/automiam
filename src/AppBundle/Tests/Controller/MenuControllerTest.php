<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MenuControllerTest extends WebTestCase
{
    public function testNewmenu()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new');
    }

    public function testEditmenu()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/edit');
    }

    public function testDeletemenu()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/delete');
    }

}
