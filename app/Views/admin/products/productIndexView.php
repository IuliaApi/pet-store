<?php

use App\Helpers\ViewHelper;

/** @var array $products */

ViewHelper::loadAdminHeader($title ?? 'Admin · Products');
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card stat-card border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-kicker mb-1">Catalog</div>
                    <h2 class="h4 mb-0">Products</h2>
                    <p class="text-secondary mb-0" style="font-size: 0.85rem;">Manage all items available in your pet store.</p>
                </div>
                <a href="<?= APP_BASE_URL ?>/admin/products/create" class="btn btn-sm btn-primary">
                    + Add product
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card bg-transparent border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle table-dark table-hover mb-0">
                <thead>
                    <tr class="text-secondary">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Brand</th>
                        <th scope="col" class="text-end">Stock</th>
                        <th scope="col" class="text-end">Price</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)) : ?>
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-4">
                                No products found yet. Start by adding one.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <th scope="row"><?= htmlspecialchars((string) $product['product_id']) ?></th>
                                <td><?= htmlspecialchars((string) $product['name']) ?></td>
                                <td><?= htmlspecialchars((string) $product['type']) ?></td>
                                <td><?= htmlspecialchars((string) $product['brand']) ?></td>
                                <td class="text-end"><?= htmlspecialchars((string) $product['stock']) ?></td>
                                <td class="text-end">$<?= htmlspecialchars((string) $product['price']) ?></td>
                                <td class="text-end">
                                    <a href="<?= APP_BASE_URL ?>/admin/products/<?= urlencode((string) $product['product_id']) 
                                    ?>/edit" class="btn btn-sm btn-outline-light">Edit</a>
                                    <a href="<?= APP_BASE_URL ?>/admin/products/<?= urlencode((string) $product['product_id']
                                    ) ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php ViewHelper::loadAdminFooter(); ?>
