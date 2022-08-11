<?php

namespace refaltor\discord\controllers;

use Discord\Discord;
use Discord\Parts\OAuth\Application;
use React\EventLoop\LoopInterface;
use refaltor\discord\Main;

class BotController
{
    private Discord $discord;

    public function __construct(Discord $discord)
    {
        $this->discord = $discord;
    }

    public function getBot(): Discord { return $this->discord;}
    public function getApp(): Application { return $this->getBot()->application;}
    private function getLoop(): LoopInterface { return $this->getBot()->getLoop();}


    public function setTimeout(int $seconds, callable $code): void {
        $this->getLoop()->addTimer($seconds, $code($this));
    }

    public function setInterval(int $seconds, callable $code): void {
        $this->getLoop()->addPeriodicTimer($seconds, $code($this));
    }

    public function log(string $msg): void {
        $botName = Main::BOT_NAME;
        echo '['.$botName.'] LOG ://' . $msg . PHP_EOL;
    }
}