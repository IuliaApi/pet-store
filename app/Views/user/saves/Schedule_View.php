<?php

use App\Helpers\ViewHelper;

$page_title = 'Appointment Schedule';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4">
    <h1 class="card-header">Your Schedule</h1>
    <div class="card-body">
        <!-- //TODO: add a table of set appoints very similar to cafe-app old index -->
    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
