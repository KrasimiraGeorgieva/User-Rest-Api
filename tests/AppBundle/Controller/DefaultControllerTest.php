<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * This functional test checks if index page is successfully loading with status code 200
     * and contains title in h1 tag.
     *
     */
    public function test_index_page(): void
    {
        $client = static::createClient();

        try{
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to User REST API!', $crawler->filter('#container h1')
            ->text());
        }
        catch (\Exception $e){
            $e->getMessage();
        }
    }
}
