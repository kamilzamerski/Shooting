<?php

namespace Tests\Functional;

class ShooterTest extends BaseTestCase
{

    public function testGetShooter()
    {
        $response = $this->runApp('GET', '/shooter/1');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, json_decode($response->getBody())->success);
    }

//    /**
//     * Test that the index route with optional name argument returns a rendered greeting
//     */
//    public function testGetHomepageWithGreeting()
//    {
//        $response = $this->runApp('GET', '/name');
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertContains('Hello name!', (string)$response->getBody());
//    }
//
//    /**
//     * Test that the index route won't accept a post request
//     */
//    public function testPostHomepageNotAllowed()
//    {
//        $response = $this->runApp('POST', '/', ['test']);
//
//        $this->assertEquals(405, $response->getStatusCode());
//        $this->assertContains('Method not allowed', (string)$response->getBody());
//    }
}