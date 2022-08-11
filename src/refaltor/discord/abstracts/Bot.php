<?php

namespace refaltor\discord\abstracts;

use Discord\Discord;
use Discord\Parts\Interactions\Command\Command as CommandDiscord;
use refaltor\discord\controllers\BotController;
use refaltor\discord\traits\LoaderTrait;

abstract class Bot
{
    use LoaderTrait;

    private BotController $botController;

    public function __construct(Discord $discord)
    {
        $this->botController = new BotController($discord);

        $this->loadCommand();
        $this->registerEvents();
    }

    abstract public function onLoading(): void;
    abstract public function onReady(): void;
    abstract public function onShutdown(): void;

    public function onCommandsRegistered(): void {
        $app = $this->getBotController()->getApp();
        foreach ($this->commands as $stdClass) {
            $name = $stdClass->name;
            $description = $stdClass->description;
            $options = $stdClass->options;
            if ($name !== 'ping') {
                $app->commands->save(new CommandDiscord($this->getBotController()->getBot(), [
                    'name' => $name,
                    'description' => $description,
                    'options' => $options,
                ]));
            }
        }
    }

    public function getBotController(): BotController { return $this->botController;}
}