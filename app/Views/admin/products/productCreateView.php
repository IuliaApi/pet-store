<?php

use App\Helpers\ViewHelper;

/** @var array $categories */

ViewHelper::loadAdminHeader($title ?? 'Admin · Create Product');
?>

<div class="row mb-4">
    <div class="col-12 col-xl-8">
        <div class="card stat-card border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="stat-kicker mb-1">Catalog</div>
                        <h2 class="h4 mb-0">Create new product</h2>
                        <p class="text-secondary mb-0" style="font-size: 0.85rem;">Add a new item to your pet store inventory.</p>
                    </div>
                </div>

                <form method="post" action="<?= APP_BASE_URL ?>/admin/products" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="50" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="stock_quantity" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" step="1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($categories as $cat) : ?>
                                    <option value="<?= htmlspecialchars((string)($cat['id'] ?? '')) ?>"><?= htmlspecialchars(ucwords((string)($cat['name'] ?? ''))) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" maxlength="50" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail filename</label>
                            <input type="text" class="form-control" id="thumbnail" name="thumbnail" maxlength="50" placeholder="e.g. chewtoy.jpg">
                            <div class="form-text text-secondary">Optional</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= APP_BASE_URL ?>/admin/products" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php ViewHelper::loadAdminFooter(); ?>
