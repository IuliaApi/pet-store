<?php

use App\Helpers\ViewHelper;

$page_title = 'Specific Product Name Here';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4">
    <h1 class="card-header">Product Name Here</h1>
    <div class="card-body">

        <img scr="" class="card-img-top">

        <!-- //TODO: add description/details -->

        <button type="submit" class="btn btn-primary">Add to cart</button>
        <button type="submit" class="btn btn-danger">Back</button>
    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
