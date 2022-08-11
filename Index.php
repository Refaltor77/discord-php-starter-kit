<?php


use Discord\Discord;
use Discord\WebSockets\Intents;
use Monolog\Logger;
use refaltor\discord\Main;

include __DIR__ . '/vendor/autoload.php';

ini_set('memory_limit', '-1');

spl_autoload_register(function (string $classname): void {
    if (str_contains($classname, "refaltor\\discord\\")) {
        $classname = "./src/" . str_replace("\\", "/", $classname) . ".php";
        require_once($classname);
    }
});

$json = json_decode(file_get_contents('./resources/config.json'), true);

$discord = new Discord([
    'token' => $json['token'],
    'loadAllMembers' => true,
    'logger' => new Logger('logger'),
    'intents' => Intents::getDefaultIntents() | Intents::GUILD_MEMBERS | Intents::GUILD_PRESENCES | Intents::GUILDS,
]);

$main = new Main($discord);

register_shutdown_function(function () use ($main): void {
    $main->onShutdown();
});

$discord->on('ready', function () use ($main): void {
    $main->onReady();
    $main->onCommandsRegistered();
});

$main->onLoading();
$discord->run();