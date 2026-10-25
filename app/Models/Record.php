<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\RecordRepositoryInterface;
use PDO;

final class Record implements RecordRepositoryInterface
{
    public function all(int $page, int $perPage, string $search, string $category, string $status): array
    {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $where  = $this->buildWhere($search, $category, $status, $params);

        $sql = "SELECT r.*, u.full_name AS created_by_name
                FROM master_records r
                LEFT JOIN users u ON u.id = r.created_by
                {$where}
                ORDER BY r.created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = Database::connection()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset,  PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function count(string $search, string $category, string $status): int
    {
        $params = [];
        $where  = $this->buildWhere($search, $category, $status, $params);
        $sql    = "SELECT COUNT(*) FROM master_records r {$where}";
        $stmt   = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM master_records WHERE id = :id LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO master_records (record_code, name, category, description, numeric_value, status, created_by)
             VALUES (:record_code, :name, :category, :description, :numeric_value, :status, :created_by)'
        );
        return $stmt->execute([
            'record_code'   => $data['record_code'],
            'name'          => $data['name'],
            'category'      => $data['category'],
            'description'   => $data['description'] ?? null,
            'numeric_value' => $data['numeric_value'],
            'status'        => $data['status'],
            'created_by'    => $data['created_by'] ?? null,
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = Database::connection()->prepare(
            'UPDATE master_records
             SET record_code = :record_code,
                 name = :name,
                 category = :category,
                 description = :description,
                 numeric_value = :numeric_value,
                 status = :status
             WHERE id = :id'
        );
        return $stmt->execute([
            'record_code'   => $data['record_code'],
            'name'          => $data['name'],
            'category'      => $data['category'],
            'description'   => $data['description'] ?? null,
            'numeric_value' => $data['numeric_value'],
            'status'        => $data['status'],
            'id'            => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = Database::connection()->prepare(
            'DELETE FROM master_records WHERE id = :id'
        );
        return $stmt->execute(['id' => $id]);
    }

    public function categories(): array
    {
        $stmt = Database::connection()->query(
            'SELECT DISTINCT category FROM master_records ORDER BY category ASC'
        );
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function countAll(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM master_records')->fetchColumn();
    }

    public function countByStatus(string $status): int
    {
        $stmt = Database::connection()->prepare(
            'SELECT COUNT(*) FROM master_records WHERE status = :status'
        );
        $stmt->execute(['status' => $status]);
        return (int) $stmt->fetchColumn();
    }

    public function countCategories(): int
    {
        return (int) Database::connection()->query(
            'SELECT COUNT(DISTINCT category) FROM master_records'
        )->fetchColumn();
    }

    public function sumNumericValue(): float
    {
        return (float) Database::connection()->query(
            'SELECT COALESCE(SUM(numeric_value), 0) FROM master_records'
        )->fetchColumn();
    }

    public function latest(int $limit): array
    {
        $stmt = Database::connection()->prepare(
            'SELECT r.*, u.full_name AS created_by_name
             FROM master_records r
             LEFT JOIN users u ON u.id = r.created_by
             ORDER BY r.created_at DESC
             LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function nextCodeNumber(): int
    {
        // Ambil nomor tertinggi dari kode berformat DATA-xxx
        $result = Database::connection()->query(
            "SELECT MAX(CAST(SUBSTRING(record_code, 6) AS UNSIGNED))
             FROM master_records
             WHERE record_code REGEXP '^DATA-[0-9]+$'"
        )->fetchColumn();

        return $result ? (int) $result + 1 : 1;
    }

    // -------------------------------------------------------------------------

    private function buildWhere(string $search, string $category, string $status, array &$params): string
    {
        $conditions = [];

        if ($search !== '') {
            $conditions[] = '(r.name LIKE :search OR r.record_code LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }

        if ($category !== '') {
            $conditions[] = 'r.category = :category';
            $params[':category'] = $category;
        }

        if ($status !== '') {
            $conditions[] = 'r.status = :status';
            $params[':status'] = $status;
        }

        return $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';
    }
}
