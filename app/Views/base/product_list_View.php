<?php

use App\Helpers\ViewHelper;

$page_title = 'Product List';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4 bg-success">
    <h1 class="card-header bg-success text-white">Search</h1>
    <div class="card-body bg-white">

        <form method="GET" action="">
            <input name="search" type="search">
            <button name="search_btn" value="name" type="submit" class="btn btn-warning">Search</button>
            &nbsp;&nbsp;
            <label>Sort by:</label>
            <select class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" id="sorting" name="sort">
                <option value="name" class="dropdown-item">Alphabet</option>
                <option value="price" class="dropdown-item">Price</option>
                <option value="stock" class="dropdown-item">Stock</option>
            </select>
            &nbsp;&nbsp;
            <label>Order by:</label>
            <select class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" id="filtering" name="order">
                <!-- //! Should allow multiple choices, but only allows one at a time-->
                <option value="ASC" class="dropdown-item">Ascending</option>
                <option value="DESC" class="dropdown-item">Descending</option>
            </select>
        </form>
    </div>
</div>

<div class="card m-4">
    <h1 class="card-header">Our catalog</h1>
    <div class="card-body">
        <!-- //TODO: add cards for each product -->
    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
