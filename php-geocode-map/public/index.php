<?php

declare(strict_types=1);

date_default_timezone_set('Europe/Istanbul');

require_once __DIR__ . '/../src/Controllers/MapController.php';


$addressService = new AddressService(__DIR__ .  '/../data/addresses.json');
$cache          = new CacheService(__DIR__ . '/../data/cache.json');
$geocoder       = new GeocodeService('php-geocode-map-case-study/1.0 (contact: benmuratyilmaz97@gmail.com)');

$controller = new MapController($addressService, $cache, $geocoder);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (($_POST['action'] ?? '') === 'geocode')) {
    $controller->postGeocode();
}

$data    = $controller->buildMapData();
$markers = $data['markers'];
$failed  = $data['failed'];
$items   = $data['items'];
$counts  = $data['counts'];

$failedOnly = (($_GET['failed'] ?? '') === '1');

if ($failedOnly) {
    $markers = [];
    $items = array_values(array_filter($items, fn($x) => ($x['status'] ?? '') === 'failed'));
}

$page = $_GET['page'] ?? 'home';
$allowed = ['home'];
if (!in_array($page, $allowed, true)) {
    $page = 'home';
}


require_once __DIR__ . '/layouts/head.php';
require_once __DIR__ . '/layouts/header.php';

$viewPath = __DIR__ . "/pages/{$page}.php";
if (file_exists($viewPath)) {
    require $viewPath;
} else {
    http_response_code(404);
    echo "<h1>404 - Sayfa bulunamadı</h1>";
}

require_once __DIR__ . '/layouts/footer.php';
