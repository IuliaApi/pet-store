<?php

use App\Helpers\ViewHelper;

/** @var array $data */

ViewHelper::loadHeader(hs(trans('receipt.receipt')));
?>

<div class="card m-4">
    <h1 class="card-header"><?= hs(trans('receipt.thank_you')) ?></h1>
    <div class="card-body">
        <?php if (empty($data['product_list'])): ?>
            <div class="alert alert-info" role="alert">
                <?= hs(trans('cart.empty')) ?> <br>
                <a href="<?= APP_BASE_URL ?>/products"><?= hs(trans('cart.find_products')) ?></a>
            </div>

        <?php else: ?>
            <ul>
                <?php foreach ($data['product_list'] as $item):
                ?>
                    <li>
                        <?= $item['quantity'] ?> <?= $item['name'] ?> $<?= $item['price'] ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <h4><?= hs(trans('cart.total')) ?> $<?= number_format($data['total'], 2) ?></h4>
    </div>
    <div class="card-footer d-flex align-items-center gap-2">
        <form method="POST" action="<?= APP_BASE_URL ?>/checkout">
            <button class="btn text-white" style="background-color: <?= GREENCOLOR ?>">
                <?= hs(trans('cart.continue_shopping')) ?>
            </button>
        </form>

    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>