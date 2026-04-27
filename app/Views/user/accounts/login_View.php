<?php

use App\Helpers\ViewHelper;

$page_title = 'Login';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4">
    <h1 class="card-header">Login to your Account</h1>
    <article class="card-body">
        <form method="POST" action="app/Middleware/authmiddleware.php">

            <label>Email:</label>
            <input name="email">

            <br>

            <label>Password:</label>
            <input name="password">

            <br>
            <br>

            <a href="">Forgot Password</a>

            <br>

            <button type="submit" class="btn btn-primary">Register</button>
            <button type="submit" class="btn btn-danger">Cancel</button>

            <br>

            <a href="/pet-store/user/registration">Create an Account</a>

        </form>
    </article>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
