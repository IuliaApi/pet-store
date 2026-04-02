<?php

use App\Helpers\ViewHelper;

$page_title = 'Contacts';
ViewHelper::loadHeader($page_title);
?>

<article class="card m-4">
    <h1 class="card-header">Account</h1>
    <section class="card-body">
        <form method="POST" action="">

            <h4>Contact Us:</h4>
            <a href="">example of a street name here</a>
            <a href="">example of an email here</a>

            <br>

            <h4>Our Socials:</h4>
            <a href="https://www.instagram.com/">Instagram</a>
            <a href="https://www.tiktok.com/">Tiktok</a>
            <a href="https://www.facebook.com/">Facebook</a>
            <a href="https://x.com/">X</a>
            <a href="https://www.youtube.com/">YouTube</a>
            <a href="https://github.com/IuliaApi/pet-store.git">GitHub</a>

        </form>
    </section>
</article>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>