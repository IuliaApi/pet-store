<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\AdminDashboardModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdminDashboardController extends BaseController
{
    public function __construct(
        Container $container,
        private AdminDashboardModel $dashboardModel
    ) {
        parent::__construct($container);
    }

    /**
     * Display the admin dashboard with e-commerce statistics.
     */
    public function dashboard(Request $request, Response $response, array $args): Response
    {
        $data = [
            'title' => 'Admin Dashboard',
            'totalProducts' => $this->dashboardModel->getTotalProducts(),
            'username' => $_SESSION['username'] ?? 'Admin',
        ];

        return $this->render($response, 'admin/dashboardView.php', $data);
    }
}
