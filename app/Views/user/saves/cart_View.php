<?php

use App\Helpers\ViewHelper;
use App\Helpers\FlashMessage;

$page_title = trans('cart.page_title');
ViewHelper::loadHeader($page_title);

$cart ??= [];
$total ??= 0;
?>

<div class="card m-4">
    <h1 class="card-header"><?= hs(trans('cart.title')) ?></h1>

    <div class="card-body">

        <?php if (empty($cart)): ?>
            <div class="alert alert-info" role="alert">
                <?= hs(trans('cart.empty')) ?> <br>
                <a href="<?= APP_BASE_URL ?>/products"><?= hs(trans('cart.find_products')) ?></a>
            </div>

        <?php else: ?>

            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th><?= hs(trans('cart.product')) ?></th>
                        <th><?= hs(trans('cart.price')) ?></th>
                        <th style="width: 180px;"><?= hs(trans('cart.quantity')) ?></th>
                        <th><?= hs(trans('cart.subtotal')) ?></th>
                        <th><?= hs(trans('cart.remove')) ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cart as $item):
                        $subtotal = $item['price'] * $item['quantity'];
                    ?>
                        <tr>
                            <td><?= hs($item['name']) ?></td>

                            <td>$<?= number_format($item['price'], 2) ?></td>

                            <td>
                                <form method="POST" action="<?= APP_BASE_URL ?>/cart/update" class="d-flex gap-1">

                                    <input type="hidden" name="productId" value="<?= $item['product_id'] ?>">

                                    <input
                                        type="number"
                                        name="quantity"
                                        value="<?= $item['quantity'] ?>"
                                        min="0"
                                        class="form-control form-control-sm"
                                        style="width: 70px;">

                                    <button class="btn btn-sm btn-primary"><?= hs(trans('cart.update')) ?></button>

                                </form>
                            </td>

                            <td>$<?= number_format($subtotal, 2) ?></td>

                            <td>
                                <form method="POST" action="<?=APP_BASE_URL?>/cart/remove">
                                    <input type="hidden" name="productId" value="<?= $item['product_id'] ?>">
                                    <button class="btn btn-sm btn-danger">X</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>

    </div>

    <div class="card-footer d-flex justify-content-between align-items-center">

        <div>
            <h4><?= hs(trans('cart.total')) ?> $<?= number_format($total, 2) ?></h4>
        </div>

        <div class="d-flex gap-2">

            <form method="GET" action="<?= APP_BASE_URL ?>/products">
                <button class="btn text-white" style="background-color: <?= SANDCOLOR ?>">
                    <?= hs(trans('cart.continue_shopping')) ?>
                </button>
            </form>

            <form method="GET" action="<?=APP_BASE_URL?>/checkout">
                <button class="btn text-white" style="background-color: <?= GREENCOLOR ?>">
                    <?= hs(trans('cart.checkout')) ?>
                </button>
            </form>

        </div>

    </div>
</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>