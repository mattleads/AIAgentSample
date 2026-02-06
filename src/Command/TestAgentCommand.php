<?php

namespace App\Command;

use Symfony\AI\Agent\AgentInterface;
use Symfony\AI\Platform\Message\Message;
use Symfony\AI\Platform\Message\MessageBag;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(name: 'app:test-agent')]
class TestAgentCommand extends Command
{
    public function __construct(
        #[Autowire(service: 'ai.agent.support_bot')]
        private readonly AgentInterface $agent) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->agent->call(new MessageBag(Message::ofUser('Hello Symfony!')));
        $output->writeln($response->getContent());
        return Command::SUCCESS;
    }
}
