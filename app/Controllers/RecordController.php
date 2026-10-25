<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\RecordRepositoryInterface;

final class RecordController extends BaseController
{
    private const PER_PAGE = 10;

    public function __construct(private readonly RecordRepositoryInterface $records) {}

    public function index(): void
    {
        $page     = max(1, (int) ($_GET['p'] ?? 1));
        $search   = trim((string) ($_GET['q'] ?? ''));
        $category = trim((string) ($_GET['category'] ?? ''));
        $status   = trim((string) ($_GET['status'] ?? ''));

        $total    = $this->records->count($search, $category, $status);
        $lastPage = max(1, (int) ceil($total / self::PER_PAGE));
        $page     = min($page, $lastPage);

        $records    = $this->records->all($page, self::PER_PAGE, $search, $category, $status);
        $categories = $this->records->categories();

        $this->renderView('records/index', [
            'title'      => 'Data Records',
            'records'    => $records,
            'categories' => $categories,
            'search'     => $search,
            'category'   => $category,
            'status'     => $status,
            'total'      => $total,
            'page'       => $page,
            'pages'      => $lastPage,
            'perPage'    => self::PER_PAGE,
        ]);
    }

    public function create(): void
    {
        $this->renderView('records/form', [
            'title'  => 'Tambah Record',
            'record' => null,
            'mode'   => 'create',
        ]);
    }

    public function store(): void
    {
        verify_csrf_or_abort();

        $data   = $this->extractInput();
        // Generate kode otomatis, abaikan input dari form
        $data['record_code'] = $this->generateCode();
        $errors = $this->validate($data);

        if ($errors) {
            set_flash('error', implode(' ', $errors));
            set_old($data);
            $this->redirectTo('records-create');
        }

        $user = auth_user();
        $data['created_by'] = $user ? $user['id'] : null;

        $this->records->create($data);
        set_flash('success', 'Record berhasil ditambahkan.');
        $this->redirectTo('records');
    }

    public function edit(int $id): void
    {
        $record = $this->records->find($id);
        if ($record === null) {
            http_response_code(404);
            render('errors/404', ['title' => 'Record tidak ditemukan']);
            return;
        }

        $this->renderView('records/form', [
            'title'  => 'Edit Record',
            'record' => $record,
            'mode'   => 'edit',
        ]);
    }

    public function update(int $id): void
    {
        verify_csrf_or_abort();

        $record = $this->records->find($id);
        if ($record === null) {
            http_response_code(404);
            render('errors/404', ['title' => 'Record tidak ditemukan']);
            return;
        }

        $data   = $this->extractInput();
        $errors = $this->validate($data, $id);

        if ($errors) {
            set_flash('error', implode(' ', $errors));
            set_old($data);
            $this->redirectTo('records-edit', ['id' => $id]);
        }

        $this->records->update($id, $data);
        set_flash('success', 'Record berhasil diperbarui.');
        $this->redirectTo('records');
    }

    public function delete(int $id): void
    {
        verify_csrf_or_abort();

        $record = $this->records->find($id);
        if ($record === null) {
            set_flash('error', 'Record tidak ditemukan.');
            $this->redirectTo('records');
        }

        $this->records->delete($id);
        set_flash('success', 'Record berhasil dihapus.');
        $this->redirectTo('records');
    }

    // -------------------------------------------------------------------------

    private function generateCode(): string
    {
        $next = $this->records->nextCodeNumber();
        return 'DATA-' . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    private function extractInput(): array
    {
        return [
            'record_code'   => trim((string) ($_POST['record_code'] ?? '')),
            'name'          => trim((string) ($_POST['name'] ?? '')),
            'category'      => trim((string) ($_POST['category'] ?? '')),
            'description'   => trim((string) ($_POST['description'] ?? '')),
            'numeric_value' => trim((string) ($_POST['numeric_value'] ?? '0')),
            'status'        => trim((string) ($_POST['status'] ?? 'active')),
        ];
    }

    private function validate(array $data, ?int $excludeId = null): array
    {
        $errors = [];

        if ($data['record_code'] === '') {
            $errors[] = 'Kode record wajib diisi.';
        } elseif (text_length($data['record_code']) > 50) {
            $errors[] = 'Kode record maksimal 50 karakter.';
        }

        if ($data['name'] === '') {
            $errors[] = 'Nama record wajib diisi.';
        } elseif (text_length($data['name']) > 120) {
            $errors[] = 'Nama record maksimal 120 karakter.';
        }

        if ($data['category'] === '') {
            $errors[] = 'Kategori wajib diisi.';
        } elseif (text_length($data['category']) > 80) {
            $errors[] = 'Kategori maksimal 80 karakter.';
        }

        if (!is_numeric($data['numeric_value'])) {
            $errors[] = 'Nilai numerik harus berupa angka.';
        }

        if (!in_array($data['status'], ['active', 'inactive'], true)) {
            $errors[] = 'Status tidak valid.';
        }

        return $errors;
    }
}
