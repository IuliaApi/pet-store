<?php

use App\Helpers\ViewHelper;

$page_title = 'Checkout';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4">
    <h1 class="card-header">Checkout</h1>
    <div class="card-body">
        <ul>
            <li>
                Amount x Item Example 1 x Price
            </li>
            <li>
                Amount x Item Example 2 x Price
            </li>
        </ul>
    </div>
    <div class="card-footer">
        <label>
            <h3>Pay</h3>
        </label>
        <button type="submit" class="btn btn-primary">Continue</button>
        <button type="submit" class="btn btn-danger">Back</button>
    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>