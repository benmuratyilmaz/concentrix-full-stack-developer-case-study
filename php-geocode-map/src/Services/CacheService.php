<?php

declare(strict_types=1);

final class CacheService
{
    private array $cache = [];

    public function __construct(private string $path)
    {
        $this->load();
    }

    private function load(): void
    {
        if (!file_exists($this->path)) {
            $this->cache = [];
            return;
        }

        $fileData = file_get_contents($this->path);
        $data = json_decode($fileData ?: '{}', true);
        $this->cache = is_array($data) ? $data : [];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->cache);
    }

    public function get(string $key): ?array
    {
        return $this->cache[$key] ?? null;
    }

    public function set(string $key, array $value): void
    {
        $this->cache[$key] = $value;
    }

    public function save(): void
    {
        $dir = dirname($this->path);
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        file_put_contents(
            $this->path,
            json_encode($this->cache, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }
}
