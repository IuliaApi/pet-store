<?php

use App\Helpers\ViewHelper;

$page_title = 'Account Details';
ViewHelper::loadHeader($page_title);
?>

<article class="card m-4">
    <h1 class="card-header">Account</h1>
    <section class="card-body">
        <p>Signed in as: <?= htmlspecialchars($username ?? 'User') ?></p>
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