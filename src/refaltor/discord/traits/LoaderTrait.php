<?php

namespace refaltor\discord\traits;

use Discord\Parts\Interactions\Interaction;
use Discord\Parts\User\Activity;
use refaltor\discord\abstracts\Command;
use refaltor\discord\abstracts\BotEvent;
use refaltor\discord\interfaces\Path;
use stdClass;

trait LoaderTrait
{
    public array $commands = [];

    public function loadCommand(): void {
        foreach (scandir(Path::COMMANDS) as $file) {
            if (is_file(Path::COMMANDS . $file)) {
                $path = str_replace(['./src/', '/'], ['', '\\'], Path::COMMANDS. str_replace('.php', '', $file));
                $command = new $path();
                if ($command instanceof Command) {
                    $this->getBotController()->getBot()->listenCommand($command->getCommandName(), function (Interaction $interaction) use ($command): void {
                        $command->execute($interaction, $this->getBotController());
                    });
                    $std = new stdClass();
                    $std->name = $command->getCommandName();
                    $std->description = $command->getDescription();;
                    $std->options = $command->getOptions();
                    $this->commands[] = $std;
                }
            }
        }
    }

    public function registerEvents(): void {
        foreach (scandir(Path::EVENTS) as $file) {
            if (is_file(Path::EVENTS . $file)) {
                $path = str_replace(['./src/', '/'], ['', '\\'], Path::EVENTS . str_replace('.php', '', $file));
                $event = new $path();
                if ($event instanceof BotEvent) {
                    $bot = $this->getBotController()->getBot();
                    $bot->on($event->getEventName(), function ($args1 = null, $args2 = null, $args3 = null) use ($event): void {
                        $event->execute($this->getBotController(), $args1, $args2, $args3);
                    });
                }
            }
        }
    }
}