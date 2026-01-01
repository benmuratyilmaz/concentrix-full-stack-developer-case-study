<?php

declare(strict_types=1);

final class FileController
{
    public function __construct(private FileService $service) {}

    private function json(int $code, array $payload): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function create(): void
    {
        try {
            if (!isset($_FILES['file'])) {
                $this->json(400, [
                    'ok' => false,
                    'data' => null,
                    'error' => ['code' => 'FILE_REQUIRED', 'message' => 'File zorunlu']
                ]);
            }

            $description = isset($_POST['description']) ? trim((string)$_POST['description']) : null;
            if ($description === '') $description = null;

            $result = $this->service->create($_FILES['file'], $description);

            if (empty($result) || !isset($result['fileId'])) {
                $this->json(500, [
                    'ok' => false,
                    'data' => null,
                    'error' => ['code' => 'INTERNAL', 'message' => 'Kayıt oluşturulamadı']
                ]);
            }

            $this->json(201, [
                'ok' => true,
                'data' => [
                    'fileId' => (int)$result['fileId'],
                    'originalName' => (string)$result['originalName'],
                    'size' => (int)$result['size'],
                    'mimeType' => (string)$result['mimeType'],
                    'checksum' => (string)$result['checksum'],
                    'createdAt' => (string)$result['createdAt'],
                ],
                'error' => null
            ]);
        } catch (ApiException $e) {
            $this->json($e->status, [
                'ok' => false,
                'data' => null,
                'error' => ['code' => $e->errorCode, 'message' => $e->getMessage()]
            ]);
        } catch (Throwable $e) {
            $this->json(500, [
                'ok' => false,
                'data' => null,
                'error' => [
                    'code' => 'INTERNAL',
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }

    public function detail(int $fileId): void
    {
        try {
            $result = $this->service->getById($fileId);

            $this->json(200, ['ok' => true, 'data' => $result, 'error' => null]);
        } catch (ApiException $e) {
            $this->json($e->status, [
                'ok' => false,
                'data' => null,
                'error' => ['code' => $e->errorCode, 'message' => $e->getMessage()],
            ]);
        } catch (Throwable $e) {
            $this->json(500, [
                'ok' => false,
                'data' => null,
                'error' => ['code' => 'INTERNAL', 'message' => $e->getMessage()],
            ]);
        }
    }

    public function list(): void
    {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $pageSize = isset($_GET['pageSize']) ? (int)$_GET['pageSize'] : 10;

            if ($page < 1 || $pageSize < 1) {
                throw new ApiException(400, 'PAGINATION_INVALID', 'page ve pageSize 1’den küçük olamaz');
            }
            if ($pageSize > 100) {
                throw new ApiException(400, 'PAGINATION_INVALID', 'pageSize en fazla 100 olabilir');
            }

            $result = $this->service->list($page, $pageSize);

            $this->json(200, ['ok' => true, 'data' => $result, 'error' => null]);
        } catch (ApiException $e) {
            $this->json($e->status, [
                'ok' => false,
                'data' => null,
                'error' => ['code' => $e->errorCode, 'message' => $e->getMessage()],
            ]);
        } catch (Throwable $e) {
            $this->json(500, [
                'ok' => false,
                'data' => null,
                'error' => ['code' => 'INTERNAL', 'message' => $e->getMessage()],
            ]);
        }
    }

    public function delete(int $fileId): void
    {
        try {
            $this->service->delete($fileId);

            $this->json(200, [
                'ok' => true,
                'data' => ['deletedId' => $fileId],
                'error' => null
            ]);
        } catch (ApiException $e) {
            $this->json($e->status, [
                'ok' => false,
                'data' => null,
                'error' => ['code' => $e->errorCode, 'message' => $e->getMessage()],
            ]);
        } catch (Throwable $e) {
            $this->json(500, [
                'ok' => false,
                'data' => null,
                'error' => ['code' => 'INTERNAL', 'message' => $e->getMessage()],
            ]);
        }
    }

    public function download(int $fileId): void
    {
        try {
            $result = $this->service->getDownloadPath($fileId);

            header('Content-Type: ' . ($result['mimeType'] ?? 'application/octet-stream'));
            header('Content-Disposition: attachment; filename="' . addslashes($result['originalName'] ?? 'download') . '"');
            header('X-Content-Type-Options: nosniff');
            header('Content-Length: ' . filesize($result['path']));

            readfile($result['path']);
            exit;
        } catch (ApiException $e) {
            $this->json($e->status, [
                'ok' => false,
                'data' => null,
                'error' => ['code' => $e->errorCode, 'message' => $e->getMessage()],
            ]);
        } catch (Throwable $e) {
            $this->json(500, [
                'ok' => false,
                'data' => null,
                'error' => ['code' => 'INTERNAL', 'message' => $e->getMessage()],
            ]);
        }
    }
}
