<?php

namespace App\Tests\Service;

use App\Service\SupportAssistant;
use PHPUnit\Framework\TestCase;
use Symfony\AI\Agent\MockAgent;

class SupportAssistantTest extends TestCase
{
    public function testAskReturnsExpectedResponse(): void
    {
        $agent = new MockAgent([
            'how do I reset my password?' => 'Go to settings and click reset.',
        ]);

        $service = new SupportAssistant($agent);

        $response = $service->ask('how do I reset my password?');
        
        $this->assertEquals('Go to settings and click reset.', $response);
        
        $agent->assertCalledWith('how do I reset my password?');
    }
}
