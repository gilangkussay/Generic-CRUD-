<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\RecordRepositoryInterface;

final class DashboardController extends BaseController
{
    public function __construct(private readonly RecordRepositoryInterface $records) {}

    public function index(): void
    {
        $stats = [
            'total'      => $this->records->countAll(),
            'active'     => $this->records->countByStatus('active'),
            'inactive'   => $this->records->countByStatus('inactive'),
            'categories' => $this->records->countCategories(),
            'sum'        => $this->records->sumNumericValue(),
        ];

        $latest = $this->records->latest(5);

        $this->renderView('dashboard/index', [
            'title'  => 'Dashboard',
            'stats'  => $stats,
            'latest' => $latest,
        ]);
    }
}
