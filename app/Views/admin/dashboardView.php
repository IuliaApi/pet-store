<?php

use App\Helpers\ViewHelper;

ViewHelper::loadAdminHeader($title);
?>

<!-- Statistics Cards -->
<div class="row mb-4 g-3">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <div class="stat-kicker mb-1">Inventory</div>
                        <div class="stat-value mb-0"><?= htmlspecialchars($totalProducts) ?></div>
                    </div>
                    <div class="stat-icon shadow-sm">
                        &#128230;
                    </div>
                </div>
                <p class="text-secondary mb-0" style="font-size: 0.8rem;">Total products currently available in your pet store.</p>
            </div>
        </div>
    </div>
</div>

<?php ViewHelper::loadAdminFooter(); ?>
