<?php

namespace App\AI\Processor;

use App\Entity\User;
use Symfony\AI\Agent\Input;
use Symfony\AI\Agent\InputProcessorInterface;
use Symfony\AI\Platform\Message\MessageBag;
use Symfony\AI\Platform\Message\SystemMessage;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(tags: ['ai.input_processor'])]
final readonly class UserContextProcessor implements InputProcessorInterface
{
    public function __construct(private Security $security) {}

    public function processInput(Input $input): void
    {
        /** @var User|null $user */
        $user = $this->security->getUser();

        if ($user) {
            $input->setMessageBag(
                (new MessageBag(
                    new SystemMessage(sprintf("Current user is %s (ID: %d)", $user->getEmail(), $user->getId()))
                ))->merge($input->getMessageBag())
            );
        }
    }
}
