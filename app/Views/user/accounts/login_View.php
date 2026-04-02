<?php

use App\Helpers\ViewHelper;

$page_title = 'Login';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4">
    <h1 class="card-header">Login to your Account</h1>
    <article class="card-body">
        <form method="POST" action="">

            <label>Email:</label>
            <input name="email">

            <br>

            <label>Password:</label>
            <input name="password">

            <br>
            <br>

            <button type="submit" class="btn btn-primary">Register</button>
            <button type="submit" class="btn btn-danger">Cancel</button>

            <br>

            <a href="">Forgot Password</a>

        </form>
    </article>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
