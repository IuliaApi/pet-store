<?php

/** @var array $product */

use App\Helpers\ViewHelper;

ViewHelper::loadHeader('Pet Shop Express · ' . hs($product['name']));
?>

<div class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="row g-0">

            <!-- Product Image -->
            <div class="col-md-5 text-center p-4">
                <img src="<?= hs($product['thumbnail']) ?>"
                    class="img-fluid rounded"
                    style="width: 100%; height: 300px; object-fit: cover;"
                    alt="<?= hs($product['name']) ?>">
            </div>

            <!-- Product Info -->
            <div class="col-md-7">
                <div class="card-body d-flex flex-column h-100">

                    <h2 class="card-title"><?= $product['name'] ?></h2>

                    <p class="text-muted mb-2">
                        Brand: <?= $product['brand'] ?? 'N/A' ?>
                    </p>

                    <h4 class="text-primary mb-3">
                        $<?= number_format($product['price'], 2) ?>
                    </h4>

                    <p class="card-text flex-grow-1">
                        <?= $product['description'] ?? 'No description available.' ?>
                    </p>

                    <p class="small text-muted">
                        Stock: <?= $product['stock_quantity'] ?>
                    </p>

                    <!-- Buttons -->
                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-success flex-fill">
                            Add to Cart
                        </button>
                        <a href="/pet-store/products" class="btn btn-outline-secondary flex-fill">
                            Back
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>