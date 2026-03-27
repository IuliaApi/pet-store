<?php

use App\Helpers\ViewHelper;

ViewHelper::loadAdminHeader($title ?? 'Admin · Categories');
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card stat-card border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-kicker mb-1">Structure</div>
                    <h2 class="h4 mb-0">Categories</h2>
                    <p class="text-secondary mb-0" style="font-size: 0.85rem;">Organize your catalog using product types.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card bg-transparent border-0">
    <div class="card-body text-secondary" style="font-size: 0.9rem;">
        <p class="mb-1">Category management UI will go here.</p>
    </div>
</div>

<?php ViewHelper::loadAdminFooter(); ?>
