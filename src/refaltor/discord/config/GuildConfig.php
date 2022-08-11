<?php

namespace refaltor\discord\config;

use Discord\Parts\Guild\Guild;

class GuildConfig implements \JsonSerializable
{
    private string $id;
    private array $caching;
    private string $file;

    public function __construct(Guild $guild)
    {
        $this->id = $guild->id;
        $this->file = './src/discord/storage/guilds/' . $this->getId() . '.json';
        $content = file_get_contents($this->getPath());
        $this->caching = [];
        if (is_string($content)) $this->caching = json_decode($content, true);
    }

    # config management
    public function set($key, $data): void {$this->caching[$key] = $data;}
    public function get($key): mixed {return $this->caching[$key] ?? null;}
    public function has($key): bool {return isset($this->caching[$key]);}

    # values
    public function getId(): string { return $this->id;}
    public function getPath(): string { return $this->file;}

    # data serialize for put content in the file
    public function jsonSerialize()
    {
        return $this->caching;
    }

    public function save(): void {
        $path = $this->getPath();
        $json = json_encode($this->jsonSerialize());
        file_put_contents($path, $json);
    }
}