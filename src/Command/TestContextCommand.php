<?php

namespace App\Command;

use App\Entity\User;
use App\Service\SupportAssistant;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

#[AsCommand(name: 'app:test-context', description: 'Tests the UserContextProcessor in a command.')]
class TestContextCommand extends Command
{
    public function __construct(
        private readonly SupportAssistant $supportAssistant,
        private readonly TokenStorageInterface $tokenStorage
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Manually create and authenticate a user for the command context.
        $user = new User();
        $user->setEmail('cli.user@example.com');

        // The firewall name 'main' must match a name in your config/packages/security.yaml
        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        $output->writeln('<info>Simulated logging in user:</info> ' . $user->getUserIdentifier());
        $output->writeln('');

        $question = 'Who am I?';
        $output->writeln(sprintf('<info>Prompting agent:</info> %s', $question));

        // The UserContextProcessor will now find the user we manually set.
        $answer = $this->supportAssistant->ask($question);

        $output->writeln('<info>Agent response:</info>');
        $output->writeln($answer);

        $output->writeln('');
        $output->writeln('<comment>Note: The UserContextProcessor added the user info to the AI prompt behind the scenes.</comment>');


        return Command::SUCCESS;
    }
}
