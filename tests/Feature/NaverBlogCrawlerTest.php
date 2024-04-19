<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\Crawler\NaverBLogService;

class NaverBlogCrawlerTest extends TestCase
{

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        // 의존성 주입
        $client = new Client();
        $this->service = new NaverBLogService($client);
    }

    /**
     * A basic feature test example.
     */
    public function test_initialState(): void
    {
        $result = $this->service->getInitialState('phjung5394');
        var_dump($result);
    }
}
