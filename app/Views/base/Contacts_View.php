<?php

use App\Helpers\ViewHelper;

$page_title = 'Contacts';
ViewHelper::loadHeader($page_title);
?>

<article class="card m-4">
    <h1 class="card-header">Contact Us</h1>
    <section class="card-body">
        <form method="POST" action="">

            <h4>Find Us Here:</h4>
            <a href="https://maps.google.com/?q=821+Sainte-Croix+Avenue,+Montr%C3%A9al,+QC+H4L+3X9" target="_blank" rel="noopener noreferrer">821 Sainte-Croix Avenue, Montréal, QC H4L 3X9</a>
            <a href="mailto:petshopexpress@gmail.com">petshopexpress@gmail.com</a>

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