<?php

use App\Helpers\ViewHelper;
use App\Helpers\FlashMessage;

$page_title = 'Shopping Cart';
ViewHelper::loadHeader($page_title);

$cart ??= [];
$total ??= 0;
?>

<div class="card m-4">
    <h1 class="card-header">Cart</h1>

    <div class="card-body">

        <?php if (empty($cart)): ?>
            <div class="alert alert-info" role="alert">
                Your cart is empty. <br>
                <a href="/pet-store/products"> Find what your pet needs here.</a>
            </div>

        <?php else: ?>

            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th style="width: 180px;">Quantity</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
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

                                    <button class="btn btn-sm btn-primary">Update</button>

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
            <h4>Total: $<?= number_format($total, 2) ?></h4>
        </div>

        <div class="d-flex gap-2">

            <form method="GET" action="<?= APP_BASE_URL?>/products">
                <button class="btn text-white" style="background-color: <?= SANDCOLOR ?>">
                    Continue Shopping
                </button>
            </form>

            <form method="GET" action="<?=APP_BASE_URL?>/checkout">
                <button class="btn text-white" style="background-color: <?= GREENCOLOR ?>">
                    Checkout
                </button>
            </form>

        </div>

    </div>
</div>

<?php
ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
