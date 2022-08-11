<?php

namespace refaltor\discord\abstracts;

use refaltor\discord\controllers\BotController;

abstract class BotEvent
{
    abstract public function getEventName(): string;

    # for see all args, please read documentation: https://discord-php.github.io/DiscordPHP/#events
    abstract public function execute(BotController $botController, $args1, $args2, $args3): void;
}