<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
    public function testNewrecipe()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new');
    }

    public function testEditrecipe()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/edit');
    }

    public function testDeleterecipe()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/delete');
    }

}
