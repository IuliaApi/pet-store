<?php

use App\Helpers\ViewHelper;

$page_title = 'Schedule An Appointment';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4">
    <h1 class="card-header">Book an Appointment</h1>
    <div class="card-body">
        <!-- //TODO: add inputs needed for an appointment -->
    </div>
    <div class="card-footer">
        <label>
            <h3>Schedule</h3>
        </label>
        <button type="submit" class="btn btn-primary">Confirm</button>
        <button type="submit" class="btn btn-danger">Cancel</button>
    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>