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
        <nav class="navbar navbar-expand-lg bg-success d-flex px-3 py-2">

            <a class="navbar-brand fw-bold" href="/pet-store/">
                Pet Shop Express
            </a>

            <form class="input-group" method="GET" action="/pet-store/search_result">
                <input type="text" class="form-control" placeholder="Search Pet Shop Express Catalogs" data-bs-theme="light">

                <button class="btn btn-warning">
                    Search
                </button>
            </form>

            <ul class="navbar-nav px-2">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/pet-store/user/">
                        Account
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/pet-store/user/cart">
                        Cart
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="navbar navbar-expand-lg bg-warning d-flex px-3 py-2">

            <!-- //TODO: add categories here -->
            <ul class="navbar-nav text-white">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="">
                        sample category
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="">
                        sample category
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="">
                        sample category
                    </a>
                </li>
            </ul>

        </nav>
    </header>
