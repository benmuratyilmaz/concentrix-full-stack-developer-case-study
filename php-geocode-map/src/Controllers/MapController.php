<?php

declare(strict_types=1);

require_once __DIR__ . '/../services/AddressService.php';
require_once __DIR__ . '/../services/CacheService.php';
require_once __DIR__ . '/../services/GeocodeService.php';

final class MapController
{
    public function __construct(
        private AddressService $addressService,
        private CacheService $cacheService,
        private GeocodeService $geocodeService
    ) {}

    public function buildMapData(): array
    {
        $addresses = $this->addressService->getAll();

        $markers = [];
        $failed  = [];
        $items   = [];

        foreach ($addresses as $index) {
            $id      = (int)($index['id'] ?? 0);
            $title   = (string)($index['title'] ?? '');
            $address = (string)($index['address'] ?? '');

            $key = AddressService::normalize($address);

            if ($this->cacheService->has($key)) {
                $c = $this->cacheService->get($key);

                if (($c['status'] ?? '') === 'success') {
                    $lat = (float)$c['lat'];
                    $lng = (float)$c['lng'];

                    $markers[] = [
                        'id' => $id,
                        'title' => $title,
                        'address' => $address,
                        'lat' => $lat,
                        'lng' => $lng,
                    ];

                    $items[] = [
                        'id' => $id,
                        'title' => $title,
                        'address' => $address,
                        'status' => 'success',
                        'lat' => $lat,
                        'lng' => $lng,
                    ];
                } else {
                    $failed[] = [
                        'id' => $id,
                        'title' => $title,
                        'address' => $address
                    ];

                    $items[] = [
                        'id' => $id,
                        'title' => $title,
                        'address' => $address,
                        'status' => 'failed',
                    ];
                }

                continue;
            }

            $geo = $this->geocodeService->geocode($address);

            if ($geo) {
                $this->cacheService->set($key, [
                    'status' => 'success',
                    'lat' => $geo['lat'],
                    'lng' => $geo['lng'],
                    'updated_at' => date('c'),
                ]);

                $markers[] = [
                    'id' => $id,
                    'title' => $title,
                    'address' => $address,
                    'lat' => $geo['lat'],
                    'lng' => $geo['lng'],
                ];

                $items[] = [
                    'id' => $id,
                    'title' => $title,
                    'address' => $address,
                    'status' => 'success',
                    'lat' => $geo['lat'],
                    'lng' => $geo['lng'],
                ];
            } else {
                $this->cacheService->set($key, [
                    'status' => 'failed',
                    'updated_at' => date('c'),
                ]);

                $failed[] = [
                    'id' => $id,
                    'title' => $title,
                    'address' => $address
                ];

                $items[] = [
                    'id' => $id,
                    'title' => $title,
                    'address' => $address,
                    'status' => 'failed',
                ];
            }

            usleep(900000);
        }

        $this->cacheService->save();

        return [
            'markers' => $markers,
            'failed'  => $failed,
            'items'   => $items,
            'counts'  => [
                'total' => count($addresses),
                'success' => count($markers),
                'failed' => count($failed),
            ],
        ];
    }


    public function postGeocode(): void
    {
        $this->buildMapData(true);

        header('Location: /?geocoded=1');
        exit;
    }
}
