<?php

declare(strict_types=1);

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../models/Material.php';

class MaterialsController
{
    public function __construct()
    {
        AuthMiddleware::check();
    }

    public function index(): void
    {
        $materialModel = new Material();
        $search        = trim($_GET['search'] ?? '');
        $materials     = $search !== '' ? $materialModel->search($search) : $materialModel->active();
        require __DIR__ . '/../views/materials/index.php';
    }
}
