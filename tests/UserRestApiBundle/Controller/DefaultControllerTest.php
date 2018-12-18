<?php

namespace UserRestApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 *
 * @package UserRestApiBundle\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * This test checks if the content-type header is application/json.
     * at api index page.
     */
    public function test_index_api(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/users');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'),
            'the "Content-Type" header is "application/json"'
        );
    }
}
