<?php

/** @var array $data */

use App\Helpers\ViewHelper;

ViewHelper::loadHeader('Product List');
?>
<div class="card m-4 ">
    <h1 class="card-header text-white" style=" background-color: <?= DARKBROWNCOLOR ?>">Search</h1>
    <div class="card-body bg-white">

        <label>Sort by:</label>
        <select class="btn" type="button" data-toggle="dropdown" aria-haspopup="true" id="sorting" name="sort" style=" background-color: <?= SANDCOLOR ?>">
            <option value="name" class="dropdown-item">Alphabet</option>
            <option value="price" class="dropdown-item">Price</option>
            <option value="stock" class="dropdown-item">Stock</option>
        </select>
        &nbsp;&nbsp;
        <label>Order by:</label>
        <select class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" id="filtering" name="order" style="background-color: <?= SANDCOLOR ?>">
            <!-- //! Should allow multiple choices, but only allows one at a time-->
            <option value="ASC" class="dropdown-item">Ascending</option>
            <option value="DESC" class="dropdown-item">Descending</option>
        </select>
        </form>
    </div>
</div>

<div class="card m-4">
    <h1 class="card-header"><?= $data['title'] ?></h1>
    <div class="card-body">
        <div class="row g-4">
            <?php if (empty($data['products'])) : ?>
                <div class="col-12">
                    <p class="text-muted">No products available yet. Please check back soon.</p>
                </div>
            <?php else : ?>
                <?php foreach ($data['products'] as $product) : ?>
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
                                    src="<?= htmlspecialchars(base_url('/assets/images/products/' . rawurlencode($thumbnail))) ?>"
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
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>