<?php

use App\Helpers\ViewHelper;

$page_title = 'Product List';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4">
    <h1 class="card-header"><?= hs(trans('home.catalog')) ?></h1>
    <div class="card-body">
        <!-- //TODO: make/add the Homepage and featured products -->
    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
