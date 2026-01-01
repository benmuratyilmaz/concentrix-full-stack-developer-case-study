<?php
declare(strict_types=1);

require __DIR__ . '/../src/ApiException.php';
require __DIR__ . '/../src/Connection/Database.php';

require __DIR__ . '/../src/Repositories/FileRepository.php';
require __DIR__ . '/../src/Services/FileServices.php';
require __DIR__ . '/../src/Controllers/FileController.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path   = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

$basePath = '';
if ($basePath !== '' && str_starts_with($path, $basePath)) {
    $path = substr($path, strlen($basePath));
}

$fileController = new FileController(
    new FileService(
        new FileRepository(Database::pdo())
    )
);

if ($path === '/api/files' && $method === 'POST') {
    $fileController->create();
}

if ($path === '/api/files' && $method === 'GET') {
    $fileController->list();
}

if (preg_match('#^/api/files/(\d+)$#', $path, $m) && $method === 'GET') {
    $fileController->detail((int)$m[1]);
}

if (preg_match('#^/api/files/(\d+)$#', $path, $m) && $method === 'DELETE') {
    $fileController->delete((int)$m[1]);
}

if (preg_match('#^/api/files/(\d+)/download$#', $path, $m) && $method === 'GET') {
    $fileController->download((int)$m[1]);
}

http_response_code(404);
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'ok' => false,
    'data' => null,
    'error' => ['code' => 'NOT_FOUND', 'message' => 'Not Found']
], JSON_UNESCAPED_UNICODE);
