<?php
echo '<nav class="navbar navbar-expand-sm navbar-light bg-light" aria-label="Third navbar example">
        <div class="container-fluid" bis_skin_checked="1">
            <a class="navbar-brand" href="#">Eshop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03"
                aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample03" bis_skin_checked="1">
                <ul class="navbar-nav ms-auto px-5 mb-2 mb-sm-0">
                    <li class="nav-item dropdown px-3">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown"
                            aria-expanded="false">Products</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="create.php">Create Product</a></li>
                            <li><a class="dropdown-item" href="read_one_product.php">Read Product</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown"
                            aria-expanded="false">Customers</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="customer.php">Create Customer</a></li>
                            <li><a class="dropdown-item" href="read_one_product.php">Read Customer</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>';
    ?>