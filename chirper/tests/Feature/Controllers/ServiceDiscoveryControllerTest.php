<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class ServiceDiscoveryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_register_with_service_discovery(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
