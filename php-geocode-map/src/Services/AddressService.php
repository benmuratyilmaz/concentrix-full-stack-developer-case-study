<?php

declare(strict_types=1);

final class AddressService
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function getAll(): array
    {
        if (!file_exists($this->filePath)) return [];

        $fileData = file_get_contents($this->filePath);
        $data = json_decode($fileData ?: '[]', true);

        return is_array($data) ? $data : [];
    }

    public static function normalize(string $address): string
    {
        $normalizeAddress = preg_replace('/\s+/', ' ', mb_strtolower(trim($address), 'UTF-8'));
        return $normalizeAddress;
    }
}
