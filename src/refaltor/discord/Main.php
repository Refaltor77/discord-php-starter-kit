<?php

namespace refaltor\discord;

use Discord\Parts\User\Activity;
use refaltor\discord\abstracts\Bot;

class Main extends Bot
{
    /*
     * Welcome to the start kit to create your bot in php!
     * This kit was made by the refaltor developer.
     *
     * This kit only works with the DiscordPHP library
     * https://github.com/discord-php
     *
     * My Github:
     * https://github.com/refaltor77
     *
     * VERSION: 1.0.0-beta
     *
     * Kiss you !
     */


    const BOT_NAME = "test";

    public function onLoading(): void
    {
        # code will be executed when the script is started.
        $this->getBotController()->log("Bot charging !");
    }

    public function onReady(): void
    {
        # code will be executed when the bot is ready.
        $this->getBotController()->log("Bot is ready !");

        # count all discord server
        $count = $this->getBotController()->getBot()->guilds->count();
        $this->getBotController()->getBot()->updatePresence(
            new Activity($this->getBotController()->getBot(), [
                'type' => Activity::TYPE_WATCHING,
                'name' => $count . " server(s)"
            ])
        );
    }

    public function onShutdown(): void
    {
        # code will be executed when the bot crashed /!\ and no stop manually !
    }
}