<?php

use App\Helpers\ViewHelper;

ViewHelper::loadAdminHeader($title ?? 'Admin · Orders');
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card stat-card border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-kicker mb-1">Operations</div>
                    <h2 class="h4 mb-0">Orders</h2>
                    <p class="text-secondary mb-0" style="font-size: 0.85rem;">Track and review customer orders and pickups.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card bg-transparent border-0">
    <div class="card-body text-secondary" style="font-size: 0.9rem;">
        <p class="mb-1">Order list and filters will be displayed here.</p>
    </div>
</div>

<?php ViewHelper::loadAdminFooter(); ?>
