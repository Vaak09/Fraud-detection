<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ScanService;
use Mockery;

class ScanServiceTest extends TestCase
{
    public function testCanPerformAScan()
    {
        $mockCustomerService = Mockery::mock(\App\Services\CustomerService::class);
        $scanService = new ScanService($mockCustomerService);

        $result = $scanService->performScan();
        $this->assertIsArray($result);
    }
}