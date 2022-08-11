<?php

namespace refaltor\discord\commands;

use Discord\Builders\MessageBuilder;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use refaltor\discord\abstracts\Command;
use refaltor\discord\controllers\BotController;

class Ping extends Command
{

    # Ping command example with args.
    # https://discord.com/developers/docs/interactions/application-commands#slash-commands

    public function getCommandName(): string
    {
        return 'ping';
    }

    public function getDescription(): string
    {
        return 'pong !';
    }

    public function getOptions(): array
    {
        return [
            [
                'name' => 'user',
                'description' => 'user',
                'type' => Option::USER,
                'required' => false
            ]
        ];
    }

    public function execute(Interaction $interaction, BotController $botController): void
    {
        $options = $interaction->data->options->offsetGet(0);

        if (is_null($options)) {
            $interaction->respondWithMessage(MessageBuilder::new()->setContent('pong ' . $interaction->user->username . ' !'));
            return;
        }

        $id = $options['value'];
        $user = $interaction->guild->members->offsetGet($id);

        if (is_null($user)) {
            $interaction->respondWithMessage(MessageBuilder::new()->setContent('pong user !'));
        } else {
            $interaction->respondWithMessage(MessageBuilder::new()->setContent('pong ' . $user->username . ' !'));
        }
    }
}