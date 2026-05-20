<?php
global $translator;
$currentLocale = $translator->getLocale();
$availableLocales = $translator->getAvailableLocales();
?>

<!DOCTYPE html>
<html lang="en"> <!-- data-bs-theme="dark" //?(want dark mode?) -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <!-- TODO: include your CSS files here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <header data-bs-theme="dark">
        <nav class="navbar navbar-expand-lg d-flex px-3 py-2" style=" background-color: <?= DARKBROWNCOLOR ?>">

            <a class="navbar-brand fw-bold d-inline-flex align-items-center" href="<?= APP_BASE_URL ?>/">
                <?= swarm_icon('tabler:paw', ['class' => 'me-1', 'width' => '18', 'height' => '18']) ?>
                Pet Shop Express
            </a>

            <form class="input-group" method="GET" action="<?= APP_BASE_URL ?>/products">
                <input type="text" name="q" class="form-control"  placeholder="<?= hs(trans('header.search_placeholder')) ?>" data-bs-theme="light">

                <button class="btn d-inline-flex align-items-center" style=" background-color: <?= SANDCOLOR ?>">
                    <?= swarm_icon('tabler:search', ['class' => 'me-1', 'width' => '18', 'height' => '18']) ?>
                    <?= hs(trans('header.search')) ?>
                </button>
            </form>

            <ul class="navbar-nav px-2">
                <li class="nav-item">
                    <a class="nav-link active d-inline-flex align-items-center" aria-current="page" href="/pet-store/login">
                        <?= swarm_icon('tabler:user', ['class' => 'me-1', 'width' => '18', 'height' => '18']) ?>
                        <?= hs(trans('header.account')) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active d-inline-flex align-items-center" href="<?= APP_BASE_URL ?>/cart">
                        <?= swarm_icon('tabler:shopping-cart', ['class' => 'me-1', 'width' => '18', 'height' => '18']) ?>
                        <?= hs(trans('header.cart')) ?>
                    </a>
                </li>
                <li>
                    <?php foreach ($availableLocales as $locale): ?>
                        <?php if ($locale !== $currentLocale): ?>
                            <a href="?lang=<?= hs($locale) ?>">
                                <?= $locale === 'en' ? 'English' : 'Français' ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </li>
            </ul>
        </nav>

        <nav class="navbar navbar-expand-lg d-flex px-3 py-2" style=" background-color: <?= BROWNCOLOR ?>">

            <!-- //TODO: add categories here -->
            <ul class=" navbar-nav text-white">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="">
                        sample category
                    </a>
                </li>
            </ul>

        </nav>
    </header>
