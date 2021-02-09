<?php

namespace Tests\Unit;

use App\Interfaces\EmailLogging;
use App\Models\EmailLog;
use App\Repositories\Database\EmailLogRepository;
use App\Services\EmailLogService;
use App\Services\EmailLogServiceInterface;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class EmailLoggingTest extends TestCase
{
    private EmailLogService $service;
    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(EmailLogServiceInterface::class);// new EmailLogService(new EmailLogRepository(new EmailLog()));
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
