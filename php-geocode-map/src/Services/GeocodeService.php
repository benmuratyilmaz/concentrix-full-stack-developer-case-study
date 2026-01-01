<?php

declare(strict_types=1);

final class GeocodeService
{
    public function __construct(
        private string $userAgent = 'php-geocode-map-case-study/1.0 (contact: benmuratyilmaz97@gmail.com)',
        private int $timeoutSeconds = 8,
        private string $baseUrl = 'https://nominatim.openstreetmap.org'
    ) {
        $this->baseUrl = rtrim($this->baseUrl, '/');
    }

    public function geocode(string $address): ?array
    {
        $address = trim($address);
        if ($address === '') return null;

        $url = $this->baseUrl . '/search?' . http_build_query([
            'format' => 'json',
            'limit'  => 1,
            'q'      => $address,
        ]);

        $context = stream_context_create([
            'http' => [
                'method'  => 'GET',
                'timeout' => $this->timeoutSeconds,
                'header'  => "User-Agent: {$this->userAgent}\r\nAccept: application/json\r\n",
            ]
        ]);

        $fileData = @file_get_contents($url, false, $context);
        if ($fileData === false) return null;

        $data = json_decode($fileData, true);
        if (!is_array($data) || count($data) === 0) return null;

        $lat = filter_var($data[0]['lat'] ?? null, FILTER_VALIDATE_FLOAT);
        $lng = filter_var($data[0]['lon'] ?? null, FILTER_VALIDATE_FLOAT);
        if ($lat === false || $lng === false) return null;

        return ['lat' => (float)$lat, 'lng' => (float)$lng];
    }
}
