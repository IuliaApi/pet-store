<?php

use App\Helpers\ViewHelper;

/** @var array $products */

ViewHelper::loadHeader($title ?? 'Shop · Products');
?>

<div class="container py-4">
    <h1 class="mb-4">Pet store products</h1>
    <div class="row g-3">
        <?php if (empty($products)) : ?>
            <div class="col-12">
                <p class="text-muted">No products available yet. Please check back soon.</p>
            </div>
        <?php else : ?>
            <?php foreach ($products as $product) : ?>
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1"><?= htmlspecialchars((string) $product['name']) ?></h5>
                            <small class="text-muted mb-2"><?= htmlspecialchars(ucwords((string) $product['type'])) ?> - <?= htmlspecialchars((string) $product['brand']) ?></small>
                            <p class="mb-2 fw-bold">$<?= htmlspecialchars((string) $product['price']) ?></p>
                            <p class="mb-3 text-muted" style="font-size: 0.85rem;">In stock: <?= htmlspecialchars((string) $product['stock']) ?></p>
                            <div class="mt-auto">
                                <button type="button" class="btn btn-sm btn-outline-primary w-100" disabled>Coming soon</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php
ViewHelper::loadFooter();
ViewHelper::loadJsScripts();
?>
