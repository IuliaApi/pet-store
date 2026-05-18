<?php

use App\Helpers\ViewHelper;


ViewHelper::loadHeader('Account Details');
?>

<article class="card m-4">
    <h1 class="card-header">Account</h1>
    <section class="card-body">
        <form method="POST" action="">

            <label>First Name:</label>
            <!-- Display first name here-->

            <br>

            <label>Last Name:</label>
            <!-- Display last name here-->

            <br>

            <label>Email:</label>
            <!-- Display email here-->

            <br>

            <a href="">Change password?</a>

        </form>
    </section>
</article>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>