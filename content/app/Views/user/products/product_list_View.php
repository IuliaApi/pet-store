<?php

use App\Helpers\ViewHelper;

$page_title = 'Product List';
ViewHelper::loadHeader($page_title);
?>

<div class="card m-4">
    <h1 class="card-header">Search</h1>
    <div class="card-body">

        <form method="GET" action="">
            <input name="search" type="search">
            <button name="search_btn" value="name" type="submit" class="btn btn-secondary">Search</button>
            &nbsp;&nbsp;
            <label>Sort by:</label>
            <select id="sorting" name="order">
                <option value="">Template 1</option>
                <option value="">Template 2</option>
            </select>
            &nbsp;&nbsp;
            <label>Filter by:</label>
            <select id="filtering" name="filter">
                <!-- //! Should allow multiple choices, but only allows one at a time-->
                <option value="">Template 1</option>
                <option value="">Template 2</option>
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