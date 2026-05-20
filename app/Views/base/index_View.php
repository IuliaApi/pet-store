<?php

use App\Helpers\ViewHelper;

/** @var array $products */

ViewHelper::loadHeader('Pet Shop Express');
?>

<!-- Carousel (Bootstrap 5) -->
<div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= asset_url('/images/carousel/welcome.jpg') ?>" class="d-block w-100" alt="Welcome" style="height: 400px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h5><?= hs(trans('home.carousel_welcome_title')) ?></h5>
                <p><?= hs(trans('home.carousel_welcome_text')) ?></p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="<?= asset_url('/images/carousel/selection.jpg') ?>" class="d-block w-100" alt="Shop Our Selection" style="height: 400px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h5><?= hs(trans('home.carousel_selection_title')) ?></h5>
                <p><?= hs(trans('home.carousel_selection_text')) ?></p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="<?= asset_url('/images/carousel/fastdelivery.jpg') ?>" class="d-block w-100" alt="Fast Delivery" style="height: 400px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h5><?= hs(trans('home.carousel_delivery_title')) ?></h5>
                <p><?= hs(trans('home.carousel_delivery_text')) ?></p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pb-0">
            <h1 class="mb-1"><?= hs(trans('home.catalog')) ?></h1>
            <p class="text-muted mb-0"><?= hs(trans('home.featured_products_description')) ?></p>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <?php if (empty($products)) : ?>
                    <div class="col-12">
                        <p class="text-muted mb-0"><?= hs(trans('products.no_products')) ?></p>
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
                            <a class="card h-100 border-0 shadow-sm overflow-hidden text-decoration-none" href="/pet-store/products/<?= $product["id"]; ?>">
                                <?php if ($hasThumbnail) : ?>
                                    <img src="<?= htmlspecialchars(base_url('/assets/images/products/' . rawurlencode($thumbnail))) ?>" class="card-img-top" alt="<?= htmlspecialchars((string) $product['name']) ?>" style="height: 200px; object-fit: cover;">
                                <?php else : ?>
                                    <div class="d-flex align-items-center justify-content-center text-white fw-semibold" style="height: 200px; background: linear-gradient(135deg, <?= SANDCOLOR ?> 0%, <?= BROWNCOLOR ?> 100%);">
                                        <div class="text-center">
                                            <i class="bi bi-image fs-1 d-block mb-2"></i>
                                            <span><?= hs(trans('products.image_coming_soon')) ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1"><?= htmlspecialchars((string) $product['name']) ?></h5>
                                    <small class="text-muted mb-2"><?= htmlspecialchars((string) ($product['category_name'] ?? 'Uncategorized')) ?> · <?= htmlspecialchars((string) $product['brand']) ?></small>
                                    <p class="text-secondary mb-3" style="font-size: 0.92rem;">
                                        <?= htmlspecialchars($description !== '' ? $description : hs(trans('products.no_description'))) ?>
                                    </p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center gap-2">
                                        <span class="fw-bold">$<?= htmlspecialchars(number_format((float) $product['price'], 2)) ?></span>
                                        <small class="text-muted"><?= hs(trans('products.stock_label')) ?> <?= htmlspecialchars((string) $product['stock_quantity']) ?></small>
                                    </div>
                                </div>
                            </a>
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