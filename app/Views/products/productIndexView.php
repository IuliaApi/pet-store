<?php

use App\Helpers\ViewHelper;

/** @var array $products */

ViewHelper::loadHeader($title ?? 'Shop · Products');
?>

<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
        <div>
            <h1 class="mb-1"><?= hs(trans('products.title')) ?></h1>
            <p class="text-muted mb-0"><?= hs(trans('products.catalog_description')) ?></p>
        </div>
        <span class="badge text-bg-secondary"><?= htmlspecialchars((string) count($products)) ?> <?= hs(trans('products.items')) ?></span>
    </div>

    <div class="m-4 d-flex align-items-center gap-2 flex-wrap">
        <form method="GET" action="<?= APP_BASE_URL ?>/products" class="d-flex align-items-center gap-2 flex-wrap">
            <?php if (!empty($query ?? '')): ?>
                <input type="hidden" name="q" value="<?= hs((string)($query ?? '')) ?>">
            <?php endif; ?>

            <label>Sort by:</label>
            <select class="btn" id="sorting" name="sort" style=" background-color: <?= SANDCOLOR ?>" onchange="this.form.submit()">
                <option value="name" class="dropdown-item" <?= (($sort ?? 'name') === 'name') ? 'selected' : '' ?>>Alphabet</option>
                <option value="price" class="dropdown-item" <?= (($sort ?? 'name') === 'price') ? 'selected' : '' ?>>Price</option>
                <option value="stock" class="dropdown-item" <?= (($sort ?? 'name') === 'stock') ? 'selected' : '' ?>>Stock</option>
            </select>
            &nbsp;&nbsp;
            <label>Order by:</label>
            <select class="btn btn-warning" id="filtering" name="order" style="background-color: <?= SANDCOLOR ?>" onchange="this.form.submit()">
                <!-- //! Should allow multiple choices, but only allows one at a time-->
                <option value="ASC" class="dropdown-item" <?= (($order ?? 'ASC') === 'ASC') ? 'selected' : '' ?>>Ascending</option>
                <option value="DESC" class="dropdown-item" <?= (($order ?? 'ASC') === 'DESC') ? 'selected' : '' ?>>Descending</option>
            </select>
        </form>
    </div>
    <div class="row g-4">
        <?php if (empty($products)) : ?>
            <div class="col-12">
                <p class="text-muted"><?= hs(trans('products.no_products')) ?></p>
            </div>
        <?php else : ?>
            <?php foreach ($products as $product) : ?>
                <?php
                $thumbnail = (string) ($product['thumbnail'] ?? '');
                $thumbnailPath = PRODUCT_IMAGES_DIR_PATH . DIRECTORY_SEPARATOR . $thumbnail;
                $hasThumbnail = $thumbnail !== '' && is_file($thumbnailPath);
                $description = trim((string) ($product['description'] ?? ''));
                // Compatibility fallbacks for older column names
                $displayType = (string) ($product['type'] ?? $product['category_name'] ?? 'Uncategorized');
                $displayStock = is_numeric($product['stock_quantity'] ?? null)
                    ? (int)$product['stock_quantity']
                    : (is_numeric($product['stock'] ?? null) ? (int)$product['stock'] : 0);
                ?>
                <div class="col-12 col-md-4 col-lg-3">
                    <a class="card h-100 shadow-sm border-0 overflow-hidden text-decoration-none" href="/pet-store/products/<?= $product["id"]; ?>">
                        <?php if ($hasThumbnail) : ?>
                            <img
                                src="<?= asset_url('/images/products/' . rawurlencode($thumbnail)) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars((string) $product['name']) ?>"
                                style="height: 220px; object-fit: cover;">
                        <?php else : ?>
                            <div class="d-flex align-items-center justify-content-center text-white fw-semibold" style="height: 220px; background: linear-gradient(135deg, <?= SANDCOLOR ?> 0%, <?= BROWNCOLOR ?> 100%);">
                                <div class="text-center">
                                    <i class="bi bi-image fs-1 d-block mb-2"></i>
                                    <span>Image coming soon</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                <div>
                                    <h5 class="card-title mb-1"><?= htmlspecialchars((string) $product['name']) ?></h5>
                                    <small class="text-muted"><?= htmlspecialchars($displayType) ?> · <?= htmlspecialchars((string) $product['brand']) ?></small>
                                </div>
                                <span class="fw-bold text-nowrap">$<?= htmlspecialchars(number_format((float) $product['price'], 2)) ?></span>
                            </div>

                            <p class="card-text text-secondary mb-3" style="font-size: 0.92rem;">
                                <?= htmlspecialchars($description !== '' ? $description : 'No description provided.') ?>
                            </p>

                            <div class="mt-auto d-flex justify-content-between align-items-center gap-2">
                                <small class="text-muted">Stock: <?= htmlspecialchars((string) $displayStock) ?></small>
                                <button type="button" class="btn btn-sm btn-outline-primary" disabled>Coming soon</button>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php
ViewHelper::loadFooter();
ViewHelper::loadJsScripts();
?>