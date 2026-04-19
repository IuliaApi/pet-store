<?php

use App\Helpers\ViewHelper;

$page_title = 'New User Registration';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4">
    <h1 class="card-header">New Account</h1>
    <article class="card-body">
        <form method="POST" action="">

            <label>First Name:</label>
            <input name="f_name">

            <br>

            <label>Last Name:</label>
            <input name="l_name">

            <br>

            <label>Email:</label>
            <input name="email">

            <br>

            <label>Password:</label>
            <input name="password_1">

            <br>

            <label>Confirm Password:</label>
            <input name="password_2">

            <br>
            <br>

            <button type="submit" class="btn btn-primary">Register</button>
            <button type="submit" class="btn btn-danger">Cancel</button>

            <br>

            <a href="/pet-store/user/">Already have an Account?</a>

        </form>
    </article>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>