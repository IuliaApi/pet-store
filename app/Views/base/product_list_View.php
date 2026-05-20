<?php

/** @var array $data */

use App\Helpers\ViewHelper;

ViewHelper::loadHeader('Product List');
?>
<div class="card m-4 ">
    <h1 class="card-header text-white" style=" background-color: <?= DARKBROWNCOLOR ?>"><?= hs(trans('products.search')) ?></h1>
    <div class="card-body bg-white">
        <form method="GET" action="<?= APP_BASE_URL ?>/search" class="d-flex align-items-center gap-2 flex-wrap">
            <?php if (!empty($data['search_keyword'] ?? '')): ?>
                <input type="hidden" name="search_keyword" value="<?= hs((string)($data['search_keyword'] ?? '')) ?>">
            <?php endif; ?>

            <label><?= hs(trans('products.sort_by')) ?></label>
            <select class="btn" id="sorting" name="sort" style=" background-color: <?= SANDCOLOR ?>" onchange="this.form.submit()">
                <option value="name" class="dropdown-item" <?= (($data['sort'] ?? 'name') === 'name') ? 'selected' : '' ?>><?= hs(trans('products.alphabet')) ?></option>
                <option value="price" class="dropdown-item" <?= (($data['sort'] ?? 'name') === 'price') ? 'selected' : '' ?>><?= hs(trans('products.price')) ?></option>
                <option value="stock" class="dropdown-item" <?= (($data['sort'] ?? 'name') === 'stock') ? 'selected' : '' ?>><?= hs(trans('products.stock')) ?></option>
            </select>
            &nbsp;&nbsp;
            <label><?= hs(trans('products.order_by')) ?></label>
            <select class="btn btn-warning" id="filtering" name="order" style="background-color: <?= SANDCOLOR ?>"
                onchange="this.form.submit()">
                <option value="ASC" class="dropdown-item" <?= (($data['order'] ?? 'ASC') === 'ASC') ? 'selected' : '' ?>><?= hs(trans('products.ascending')) ?></option>
                <option value="DESC" class="dropdown-item" <?= (($data['order'] ?? 'ASC') === 'DESC') ? 'selected' : '' ?>><?= hs(trans('products.descending')) ?></option>
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
                    <p class="text-muted"><?= hs(trans('products.no_products')) ?></p>
                </div>
            <?php else : ?>
                <?php foreach ($data['products'] as $product) : ?>
                    <?php
                    $thumbnail = (string) ($product['thumbnail'] ?? '');
                    $thumbnailPath = PRODUCT_IMAGES_DIR_PATH . DIRECTORY_SEPARATOR . $thumbnail;
                    $hasThumbnail = $thumbnail !== '' && is_file($thumbnailPath);
                    $description = trim((string) ($product['description'] ?? ''));
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
                                        <span><?= hs(trans('products.image_coming_soon')) ?></span>
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
                                    <?= htmlspecialchars($description !== '' ? $description : hs(trans('products.no_description'))) ?>
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center gap-2">
                                    <small class="text-muted"><?= hs(trans('products.stock_label')) ?> <?= htmlspecialchars((string) $displayStock) ?></small>
                                    <button type="button" class="btn btn-sm btn-outline-primary" disabled><?= hs(trans('products.coming_soon')) ?></button>
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
