<?php

namespace UserRestApiBundle\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserControllerTest
 *
 * @package UserRestApiBundle\Tests
 */
class UserControllerTest extends WebTestCase
{
    public function test_get_all_expected_status_200()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        $client->request('GET', '/api/v1/users');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // asserts that the "Content-Type" header is "application/json"
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'The "Content-Type" header should be "application/json"'
        );
    }

    public function test_notEmpty_data_expected_filled_in_fields()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        $data = array(
            'email' => 'gosho88@yahoo.com',
            'givenName' => 'Gosho',
            'familyName' => 'Peshev',
        );

        $client->request('POST', '/api/v1/users', array($data));

        $this->assertNotEmpty($data);
    }

    public function test_create_user_expected_status_201()
    {
        $client = new Client();

        try {
            $response = $client->request('POST', 'http://127.0.0.1:8000/api/v1/users',
                array(
                    'form_params' => array(
                        'email' => 'pesho@yahoo.com',
                        'givenName' => 'Pesho',
                        'familyName' => 'Ivanov',
                    ))
            );
            $this->assertEquals(201, $response->getStatusCode());
        } catch (GuzzleException $e) {
            echo $e->getMessage();
        }
    }

    public function test_edit_user_expected_status_201()
    {
        $client = new Client();
        $client->requestAsync('POST', 'http://127.0.0.1:8000/api/v1/users', array(
            'form_params' => array(
                'email' => 'stamat98@yahoo.com',
                'givenName' => 'Stamat',
                'familyName' => 'Ivanov'
            )));

        try {
            $response = $client->put('http://127.0.0.1:8000/api/v1/users/2', array(
                'form_params' => array(
                    'email' => 'stamat@gmail.com',
                    'givenName' => 'Stamat',
                    'familyName' => 'Ivanov'
                ), 'timeout' => 5
            ));
            $this->assertEquals(204, $response->getStatusCode());
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function test_delete_user_expected_status_204_ex404()
    {
        $client = new Client();
        // Make sure the id user in uri exists in database
        $response = $client->delete('http://127.0.0.1:8000/api/v1/users/26');
        $this->assertEquals(204, $response->getStatusCode());
    }
}