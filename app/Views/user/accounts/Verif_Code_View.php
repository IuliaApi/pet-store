<?php

use App\Helpers\ViewHelper;

ViewHelper::loadHeader('Verification');
?>

<div class="card m-4">
    <h1 class="card-header">Account Verification</h1>
    <article class="card-body">
        <form method="POST" action="">

            <h5>A 6 digit code was sent to your email, please re-enter it here:</h5>

            <label>6 digit code</label>
            <input name="email" placeholder="Enter code here">

            <br>
            <br>

            <a href="">Resend code</a>

            <br>

            <button type="submit" class="btn btn-primary">Register</button>
            <button type="submit" class="btn btn-danger">Cancel</button>


        </form>
    </article>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>