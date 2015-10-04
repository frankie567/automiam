<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TagControllerTest extends WebTestCase
{
    public function testNewtag()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new');
    }

}
