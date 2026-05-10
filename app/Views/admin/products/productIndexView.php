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
                    <p class="text-secondary mb-0" style="font-size: 0.85rem;">Manage all items available in our pet store.</p>
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
            <table class="table align-middle table-hover mb-0">
                <thead>
                    <tr class="text-secondary">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
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
                                <th scope="row"><?= htmlspecialchars((string) $product['id']) ?></th>
                                <td><?= htmlspecialchars((string) $product['name']) ?></td>
                                <td><?= htmlspecialchars((string) $product['category_name']) ?></td>
                                <td><?= htmlspecialchars((string) $product['brand']) ?></td>
                                <td class="text-end"><?= htmlspecialchars((string) $product['stock_quantity']) ?></td>
                                <td class="text-end">$<?= htmlspecialchars((string) $product['price']) ?></td>
                                <td class="text-end">
                                    <a href="<?= APP_BASE_URL ?>/admin/products/<?= urlencode((string) $product['id'])
                                    ?>/edit" class="btn btn-sm btn-warning text-dark d-inline-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                        <span>Edit</span>
                                    </a>
                                    <a href="<?= APP_BASE_URL ?>/admin/products/<?= urlencode((string) $product['id']
                                    ) ?>/delete" class="btn btn-sm btn-danger text-white d-inline-flex align-items-center gap-1" onclick="return confirm('Delete this product?');">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                        <span>Delete</span>
                                    </a>
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
