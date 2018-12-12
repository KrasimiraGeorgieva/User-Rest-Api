<?php

namespace AppBundle\tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * This functional test checks if application pages are successfully loading.
     *
     * @dataProvider urlProvider
     * @param $url
     */
    public function test_page_isSuccessful($url): void
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider(): array
    {
        return array(
            array('/'),
            array('users/'),
            array('users/new'),
            array('users/1'),
            array('users/1/edit'),
            array('/api/v1/users'),
            array('/api/v1/users/1'),
        );
    }
}
