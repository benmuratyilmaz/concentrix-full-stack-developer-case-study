<?php
declare(strict_types=1);

// .env dosyasını okuyup $_ENV'e doldur
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
  $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '' || str_starts_with($line, '#')) continue;

    [$key, $val] = array_map('trim', explode('=', $line, 2));
    $val = trim($val, "\"'"); // "..." veya '...' tırnaklarını kaldır

    $_ENV[$key] = $val;
  }
}