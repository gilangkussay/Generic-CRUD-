<?php
declare(strict_types=1);

namespace App\Core;

abstract class BaseController
{
    protected function renderView(string $view, array $data = []): void
    {
        render($view, $data);
    }

    protected function redirectTo(string $page, array $params = []): never
    {
        redirect(url($page, $params));
    }
}
