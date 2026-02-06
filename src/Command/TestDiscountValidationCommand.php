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

#[AsCommand(name: 'app:test-discount', description: 'Tests the DiscountTool and its validation.')]
class TestDiscountValidationCommand extends Command
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
            ->addArgument('percentage', InputArgument::REQUIRED, 'The discount percentage to set.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $percentage = (int) $input->getArgument('percentage');

        $prompt = sprintf('Set a discount of %d percent.', $percentage);

        $output->writeln(sprintf('<info>Prompting agent with discount:</info> %d%%', $percentage));
        $output->writeln(sprintf('<info>Prompt:</info> %s', $prompt));

        $response = $this->agent->call(new MessageBag(Message::ofUser($prompt)));

        $output->writeln('<info>Agent response:</info>');
        $output->writeln($response->getContent());

        return Command::SUCCESS;
    }
}
