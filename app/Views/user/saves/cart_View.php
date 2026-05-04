<?php

use App\Helpers\ViewHelper;

$page_title = 'Shopping Cart';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4">
    <h1 class="card-header">Cart</h1>
    <div class="card-body">
        <!-- //TODO: add a table of items, amount buying (+ or -), option to remove from cart-->
    </div>
    <div class="card-footer">
        <h3>Proceed to Checkout</h3>
        <label>
            <h4>Total:</h4>
            <!-- //TODO: A price count here -->
        </label>
        <button type="submit" class="btn text-white" style=" background-color: <?= GREENCOLOR ?>">Checkout</button>
        <button type="submit" class="btn text-white" style=" background-color: <?= SANDCOLOR ?>">Continue Shopping</button>
    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
