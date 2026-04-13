<?php

use App\Helpers\ViewHelper;

/** @var array $product */
/** @var array $types */

ViewHelper::loadAdminHeader($title ?? 'Admin · Edit Product');
?>

<div class="row mb-4">
    <div class="col-12 col-xl-8">
        <div class="card stat-card border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="stat-kicker mb-1">Catalog</div>
                        <h2 class="h4 mb-0">Edit product</h2>
                        <p class="text-secondary mb-0" style="font-size: 0.85rem;">Update details for this item.</p>
                    </div>
                </div>

                <form method="post" action="<?= APP_BASE_URL ?>/admin/products/<?= urlencode((string) $product['id']) ?>" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="50" required value="<?= htmlspecialchars((string) $product['name']) ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" min="0" step="1" required value="<?= htmlspecialchars((string) $product['stock']) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required value="<?= htmlspecialchars((string) $product['price']) ?>">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Category</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($types as $type) : ?>
                                    <option value="<?= htmlspecialchars($type) ?>" <?= $product['type'] === $type ? 'selected' : '' ?>>
                                        <?= htmlspecialchars(ucwords($type)) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" maxlength="50" required value="<?= htmlspecialchars((string) $product['brand']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail filename</label>
                            <input type="text" class="form-control" id="thumbnail" name="thumbnail" maxlength="50" value="<?= htmlspecialchars((string) $product['thumbnail']) ?>">
                            <div class="form-text text-secondary">Optional</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= APP_BASE_URL ?>/admin/products" class="btn btn-outline-secondary">Back to list</a>
                        <button type="submit" class="btn btn-primary">Update product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php ViewHelper::loadAdminFooter(); ?>
