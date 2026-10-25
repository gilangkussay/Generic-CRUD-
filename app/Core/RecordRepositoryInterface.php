<?php
declare(strict_types=1);

namespace App\Core;

interface RecordRepositoryInterface
{
    public function all(int $page, int $perPage, string $search, string $category, string $status): array;

    public function count(string $search, string $category, string $status): int;

    public function find(int $id): ?array;

    public function create(array $data): bool;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function categories(): array;

    public function countAll(): int;

    public function countByStatus(string $status): int;

    public function countCategories(): int;

    public function sumNumericValue(): float;

    public function latest(int $limit): array;

    public function nextCodeNumber(): int;
}
