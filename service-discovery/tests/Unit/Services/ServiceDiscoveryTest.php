<?php

namespace Tests\Unit\Services;

use App\Services\ServiceDiscovery;
use PHPUnit\Framework\TestCase;

class ServiceDiscoveryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_services_exist_on_instantiation(): void
    {
        $serviceDiscovery = new ServiceDiscovery();

        if (is_null($serviceDiscovery->getServices())) {
            $this->fail("Services were not auto created");
        }

        $this->assertTrue(true);
    }

    public function test_can_generate_tokens_against_blirp_service(): void
    {
        $serviceDiscovery = new ServiceDiscovery();

        $tokens = $serviceDiscovery->generateTokens();

        $this->assertNotNull($tokens);
    }
}
