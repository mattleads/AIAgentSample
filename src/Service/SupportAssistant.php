<?php

namespace App\Service;

use Symfony\AI\Agent\AgentInterface;
use Symfony\AI\Platform\Message\Message;
use Symfony\AI\Platform\Message\MessageBag;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class SupportAssistant
{
    public function __construct(
        #[Autowire(service: 'ai.agent.support_bot')]
        private AgentInterface $agent
    ) {}

    public function ask(string $userQuestion): string
    {
        $messages = new MessageBag(
            Message::ofUser($userQuestion)
        );

        $response = $this->agent->call($messages);

        return $response->getContent();
    }
}
