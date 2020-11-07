<?php

namespace Tests\Unit;

use App\Interfaces\EmailLogging;
use App\Models\EmailLog;
use App\Repositories\Database\EmailLogRepository;
use App\Services\EmailLogService;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class EmailLoggingTest extends TestCase
{
    private EmailLogService $service;
    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new EmailLogService(new EmailLogRepository(new EmailLog()));
    }

    public function testSavingLog()
    {
        $log = $this->service->makeItem([
            'recourse' => self::class,
            'operation' => EmailLogging::CREATE_OPERATION,
            'description' => Factory::create()->realText()
        ]);

        $this->assertInstanceOf(
            Model::class,
            $log
        );

        $log->delete();
    }
}
