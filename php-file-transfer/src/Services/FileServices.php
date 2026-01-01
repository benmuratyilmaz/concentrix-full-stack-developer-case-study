<?php

declare(strict_types=1);

final class FileService
{

    private const MAX_BYTES = 10 * 1024 * 1024;

    private array $allowedExt = ['pdf', 'jpg', 'png', 'txt'];

    private array $allowedMime = [
        'pdf' => ['application/pdf'],
        'jpg' => ['image/jpeg'],
        'png' => ['image/png'],
        'txt' => ['text/plain', 'application/octet-stream'],
    ];

    public function __construct(private FileRepository $fileRepository) {}

    public function create(array $uploadedFile, ?string $description): array
    {
        try {
            if (!isset($uploadedFile['error']) || $uploadedFile['error'] !== UPLOAD_ERR_OK) {
                throw new ApiException(400, 'UPLOAD_ERROR', 'Dosya yükleme hatası');
            }

            $originalName = basename((string)($uploadedFile['name'] ?? 'file'));
            $size = (int)($uploadedFile['size'] ?? 0);

            if ($size <= 0) {
                throw new ApiException(400, 'FILE_REQUIRED', 'Herhangi bir dosya atılmadı');
            }

            if ($size > self::MAX_BYTES) {
                throw new ApiException(413, 'FILE_TOO_LARGE', 'Dosya boyutu 10MB\'ı geçemez');
            }

            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            if (!in_array($ext, $this->allowedExt, true)) {
                throw new ApiException(415, 'UNSUPPORTED_TYPE', 'Sadece PDF, JPG, PNG, TXT dosyaları yüklenebilir');
            }

            $tmp = (string)($uploadedFile['tmp_name'] ?? '');

            if ($tmp === '' || !is_uploaded_file($tmp)) {
                throw new ApiException(400, 'INVALID_UPLOAD', 'Geçersiz dosya');
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($tmp) ?: 'application/octet-stream';

            if (!isset($this->allowedMime[$ext]) || !in_array($mimeType, $this->allowedMime[$ext], true)) {
                throw new ApiException(422, 'MIME_MISMATCH', 'Dosya içeriği geçersiz (MIME uyuşmuyor)');
            }

            $checksum = hash_file('sha256', $tmp);

            $uploadsDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($uploadsDir)) {
                if (!mkdir($uploadsDir, 0777, true) && !is_dir($uploadsDir)) {
                    throw new ApiException(500, 'MKDIR_FAILED', 'Uploads dizini oluşturulamadı');
                }
            }

            $tmpStored = bin2hex(random_bytes(8)) . '.' . $ext;
            $tmpTarget = $uploadsDir . $tmpStored;

            if (!move_uploaded_file($tmp, $tmpTarget)) {
                throw new ApiException(500, 'SAVE_FAILED', 'Dosya kaydedilemedi');
            }

            $result = [
                'originalName' => $originalName,
                'url' => '/uploads/' . $tmpStored,
                'description' => $description,
                'size' => $size,
                'mimeType' => $mimeType,
                'checksum' => $checksum,
            ];

            $created = $this->fileRepository->create($result);
            $fileId = (int)($created['fileId'] ?? 0);

            if ($fileId <= 0) {
                @unlink($tmpTarget);
                throw new ApiException(500, 'DB_INSERT_FAILED', 'Veritabanı kaydı oluşturulamadı');
            }

            return $this->fileRepository->findByID($fileId) ?? [];
        } catch (Throwable $e) {
            error_log('[FileService::create] ' . $e->getMessage());
            throw $e;
        }
    }

    public function getById(int $fileId): array
    {
        try {
            $result = $this->fileRepository->findByID($fileId);
            if (!$result) {
                throw new ApiException(404, 'NOT_FOUND', 'Dosya bulunamadı');
            }
            return $result;
        } catch (Throwable $e) {
            error_log('[FileService::getById] fileId=' . $fileId . ' | ' . $e->getMessage());
            throw $e;
        }
    }

    public function list(int $page, int $pageSize): array
    {
        try {
            return $this->fileRepository->list($page, $pageSize);
        } catch (Throwable $e) {
            error_log('[FileService::list] page=' . $page . ' pageSize=' . $pageSize . ' | ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete(int $fileId): void
    {
        try {
            $result = $this->fileRepository->delete($fileId);
            if (!$result) {
                throw new ApiException(500, 'DELETE_FAILED', 'Silme başarısız');
            }
        } catch (Throwable $e) {
            error_log('[FileService::delete] fileId=' . $fileId . ' | ' . $e->getMessage());
            throw $e;
        }
    }

    public function getDownloadPath(int $fileId): array
    {
        try {
            $result = $this->fileRepository->findByID($fileId);
            if (!$result) {
                throw new ApiException(404, 'NOT_FOUND', 'Dosya bulunamadı');
            }

            $storedName = basename((string)($result['url'] ?? ''));
            $fullPath = __DIR__ . '/../../public/uploads/' . $storedName;

            if (!$storedName || !is_file($fullPath)) {
                throw new ApiException(404, 'FILE_MISSING', 'Dosya disk üzerinde bulunamadı');
            }

            return [
                'path' => $fullPath,
                'mimeType' => $result['mimeType'],
                'originalName' => $result['originalName'],
            ];
        } catch (Throwable $e) {
            error_log('[FileService::getDownloadPath] fileId=' . $fileId . ' | ' . $e->getMessage());
            throw $e;
        }
    }
}
