<?php
declare(strict_types=1);

namespace Genkgo\TestMail\Unit\Protocol\Smtp\Request;

use Genkgo\Mail\Protocol\ConnectionInterface;
use Genkgo\Mail\Protocol\Smtp\Request\AuthPlainCredentialsRequest;
use Genkgo\TestMail\AbstractTestCase;

final class AuthPlainCredentialsRequestTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function it_executes()
    {
        $connection = $this->createMock(ConnectionInterface::class);
        $connection
            ->expects($this->once())
            ->method('send')
            ->with("AHRlc3QAdGVzdA==");

        $command = new AuthPlainCredentialsRequest('test', 'test');
        $command->execute($connection);
    }

}