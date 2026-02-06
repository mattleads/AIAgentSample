<?php

namespace App\Command;

use Symfony\AI\Agent\AgentInterface;
use Symfony\AI\Platform\Message\Message;
use Symfony\AI\Platform\Message\MessageBag;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(name: 'app:test-tool', description: 'Tests the OrderStatusTool by asking the AI to get an order status.')]
class TestToolCommand extends Command
{
    public function __construct(
        #[Autowire(service: 'ai.agent.default')]
        private readonly AgentInterface $agent
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('orderId', InputArgument::REQUIRED, 'The order ID to check.')
            ->addArgument('region', InputArgument::REQUIRED, 'The region of the order (us, eu, or asia).');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $orderId = $input->getArgument('orderId');
        $region = $input->getArgument('region');

        $prompt = sprintf('What is the status of order %s in the %s region?', $orderId, $region);

        $output->writeln(sprintf('<info>Prompting agent:</info> %s', $prompt));

        $response = $this->agent->call(new MessageBag(Message::ofUser($prompt)));

        $output->writeln('<info>Agent response:</info>');
        $output->writeln($response->getContent());

        return Command::SUCCESS;
    }
}
