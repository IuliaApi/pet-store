<?php

use App\Helpers\ViewHelper;

/** @var array $products */

$page_title = 'Product List';
ViewHelper::loadHeader($page_title);
?>

<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pb-0">
            <h1 class="mb-1"><?= hs(trans('home.catalog')) ?></h1>
            <p class="text-muted mb-0">Featured products from the catalogue.</p>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <?php if (empty($products)) : ?>
                    <div class="col-12">
                        <p class="text-muted mb-0">No products available yet. Please check back soon.</p>
                    </div>
                <?php else : ?>
                    <?php foreach ($products as $product) : ?>
                        <?php
                        $thumbnail = (string) ($product['thumbnail'] ?? '');
                        $thumbnailPath = PRODUCT_IMAGES_DIR_PATH . DIRECTORY_SEPARATOR . $thumbnail;
                        $hasThumbnail = $thumbnail !== '' && is_file($thumbnailPath);
                        $description = trim((string) ($product['description'] ?? ''));
                        ?>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                <?php if ($hasThumbnail) : ?>
                                    <img src="<?= htmlspecialchars(base_url('/assets/images/products/' . rawurlencode($thumbnail))) ?>" class="card-img-top" alt="<?= htmlspecialchars((string) $product['name']) ?>" style="height: 200px; object-fit: cover;">
                                <?php else : ?>
                                    <div class="d-flex align-items-center justify-content-center text-white fw-semibold" style="height: 200px; background: linear-gradient(135deg, <?= SANDCOLOR ?> 0%, <?= BROWNCOLOR ?> 100%);">
                                        <div class="text-center">
                                            <i class="bi bi-image fs-1 d-block mb-2"></i>
                                            <span>Image coming soon</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1"><?= htmlspecialchars((string) $product['name']) ?></h5>
                                    <small class="text-muted mb-2"><?= htmlspecialchars((string) ($product['category_name'] ?? 'Uncategorized')) ?> · <?= htmlspecialchars((string) $product['brand']) ?></small>
                                    <p class="text-secondary mb-3" style="font-size: 0.92rem;">
                                        <?= htmlspecialchars($description !== '' ? $description : 'No description provided.') ?>
                                    </p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center gap-2">
                                        <span class="fw-bold">$<?= htmlspecialchars(number_format((float) $product['price'], 2)) ?></span>
                                        <small class="text-muted">Stock: <?= htmlspecialchars((string) $product['stock_quantity']) ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
