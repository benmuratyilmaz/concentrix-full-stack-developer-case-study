<?php

declare(strict_types=1);

final class FileRepository
{
    public function __construct(private PDO $pdo) {}

    public function create(array $row): array
    {
        $sql = "INSERT INTO files (originalName, url, description, size, mimeType, checksum, createdAt)
                VALUES (:originalName, :url, :description, :size, :mimeType, :checksum, NOW())";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':originalName' => $row['originalName'],
            ':url' => $row['url'],
            ':description' => $row['description'],
            ':size' => $row['size'],
            ':mimeType' => $row['mimeType'],
            ':checksum' => $row['checksum'],
        ]);

        $fileId = (int)$this->pdo->lastInsertId();

        return $this->findByID($fileId) ?? [];
    }

    public function delete(int $fileId): bool
    {
        $sql = "UPDATE files SET deletedAt = NOW() WHERE fileId = :tmpFileId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':tmpFileId' => $fileId]);

        return $stmt->rowCount() > 0;
    }

    public function findByID(int $fileId): ?array
    {
        $sql = "SELECT fileId, originalName, CONCAT('http://localhost:8000', url) AS url, description, size, mimeType, checksum, createdAt
                FROM files WHERE fileId = :tmpfileId LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':tmpfileId' => $fileId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function list(int $page, int $pageSize): array
    {
        $page = max(1, $page);
        $pageSize = max(1, min(100, $pageSize));
        $offset = ($page - 1) * $pageSize;

        $total = (int)$this->pdo->query("SELECT COUNT(*) FROM files")->fetchColumn();

        $stmt = $this->pdo->prepare("
            SELECT fileId, originalName, CONCAT('http://localhost:8000', url) AS url, size, mimeType, checksum, createdAt
            FROM files
            WHERE deletedAt IS NULL
            ORDER BY createdAt DESC
            LIMIT :limit OFFSET :offset
        ");

        $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'items' => $items,
        ];
    }

}
