<?php

namespace refaltor\discord\abstracts;

use Discord\Parts\Interactions\Interaction;
use refaltor\discord\controllers\BotController;

abstract class Command
{
    abstract public function getCommandName(): string;
    abstract public function getDescription(): string;
    abstract public function getOptions(): array;

    abstract public function execute(Interaction $interaction, BotController $botController): void;
}