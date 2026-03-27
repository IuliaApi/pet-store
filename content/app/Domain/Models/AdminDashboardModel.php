<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class AdminDashboardModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    public function getTotalProducts(): int
    {
        return $this->count('SELECT COUNT(*) FROM products');
    }
}
