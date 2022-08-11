<?php

namespace refaltor\discord\events;

use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;
use refaltor\discord\abstracts\BotEvent;
use refaltor\discord\controllers\BotController;

class MessageCreate extends BotEvent
{

    public function getEventName(): string
    {
        return Event::MESSAGE_CREATE;
    }

    public function execute(BotController $botController, $args1, $args2, $args3): void
    {
        if ($args1 instanceof Message) {
            if (!$args1->author?->bot) {
                if ($args1->content === 'hey')  {
                    $args1->react('👏');
                }
            }
        }
    }
}