<?php

namespace Tests\Unit\Services\Api;

use App\Models\Token;
use App\Models\User;
use App\Repositories\TokenRepository;
use App\Services\Api\ChirperService;
use App\Services\ServiceDiscovery;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Mockery\MockInterface;
use Mockery as m;

class ChirperServiceTest extends TestCase
{
    public function setUp(): void
    {
        $this->user = m::mock(User::class, [
            'getId' => 1,
            'getName' => 'Test McTest'
        ]);

        $this->blirpsRawJson = [
            [
                'user_id' => 1,
                'message' => 'text for message 1'
            ],
            [
                'user_id' => 1,
                'message' => 'text for message 2'
            ]
        ];

        $this->chirperService = App::make(ServiceDiscovery::class);

        parent::setUp();
    }

    public function test_service_can_pull_single_blirp()
    {
        $results = $this->chirperService->read(1);

        $this->assertNotEmpty($results);
    }

    public function test_service_can_pull_all_blirps()
    {
        $results = $this->chirperService->read();

        $this->assertNotEmpty($results);
    }
}
