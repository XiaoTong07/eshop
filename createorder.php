<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Order</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
</head>

<body>
    <div class="menu">
        <?php include 'navigationbar.php'; ?>
    </div>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Order</h1>
        </div>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='post'>
            <table class='table table-hover table-responsive table-bordered'>
                <?php
                include 'config/database.php';

                if ($_POST) {
                    // include database connection
                    // echo "<pre>";
                    // var_dump($product_id);
                    // echo "</pre>";

                    // posted values
                    $customer = $_POST['customer'];
                    $product_id = $_POST['product_id'];
                    $quantity = $_POST['quantity'];
                    $flag = 1;

                    if ($customer == "") {
                        $flag = 0;
                    }

                    for ($y = 0; $y < count($product_id); $y++) {
                        if ($product_id[$y] == ""|| $quantity[$y]=="") {
                            $flag = 0;
                        }
                    }

                    if ($flag == 1) {
                        // insert query
                        $query = "INSERT INTO orders SET customer=:customer";
                        $stmt = $con->prepare($query);

                        $stmt->bindParam(':customer', $customer);
                        $stmt->execute();
                        $id = $con->lastInsertId();
                        echo "<div class='alert alert-success'>Record was saved. The Order ID is $id.</div>";

                        for ($y = 0; $y < count($product_id); $y++) {
                            // insert query
                            $query = "INSERT INTO orderdetails SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                            // prepare query for execution
                            $stmt = $con->prepare($query);

                            // bind the parameters
                            $stmt->bindParam(':order_id', $id);
                            $stmt->bindParam(':product_id', $product_id[$y]);
                            $stmt->bindParam(':quantity', $quantity[$y]);

                            $stmt->execute();
                        }
                    }else{
                        echo "<div class='alert alert-danger'>Please fill in all information.</div>"; 
                    }

                    if(count($product_id) != count(array_unique($product_id))){
                        $flag = 0;
                        echo "<div class='alert alert-danger'>Selected product cannot be repeated</div>";
                    }
                }

                echo "<tr>";
                echo "<td>Customer ID</td>";
                echo "<td>";
                $query = "SELECT firstname , lastname, username FROM customers ORDER BY username DESC";
                $stmt = $con->prepare($query);
                $stmt->execute();

                $num = $stmt->rowCount();

                if ($num > 0) {

                    echo "<select class='form-select' aria-label='Default select example' name='customer'>";
                    echo "<option value=''>Username</option>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<option value=$username>$firstname $lastname";
                        echo "</option>";
                    }
                    echo "</select>";
                }
                echo "</td>";
                echo "</tr>";
                ?>

                <tr class=productQuantity>
                    <td>Products</td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <?php
                                $productquery = "SELECT id, name FROM products ORDER BY id DESC";
                                $productstmt = $con->prepare($productquery);
                                $productstmt->execute();
                                $productnum = $productstmt->rowCount();

                                //$stmt->bindParam(':quantity', $product_id[$orderQuantityA]);
                                if ($productnum > 0) {

                                    echo "<select class= 'form-select' aria-label='Default select example' name='product_id[]'>";
                                    echo "<option value=''>Product</option>";
                                    while ($row = $productstmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                        echo "<option value=$id>$name";
                                        echo "</option>";
                                    }
                                    echo "</select>";
                                }
                                ?>
                            </div>
                            <div class="col">
                                <select class='form-select' aria-label='Default select example' name='quantity[]'>
                                    <option value=''>Quantity</option>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                </select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="d-flex justify-content-center flex-column flex-lg-row">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="add_one btn mb-1 mx-2">Add More Product</button>
                                <button type="button" class="del_last btn mb-1 mx-2">Delete Last Product</button>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type='submit' value='Submit' class='btn btn-primary' /></td>
                </tr>
            </table>

        </form>

        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <script>
            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var element = document.querySelector('.productQuantity');
                    var clone = element.cloneNode(true);
                    element.after(clone);
                }
                if (event.target.matches('.del_last')) {
                    var total = document.querySelectorAll('.productQuantity').length;
                    if (total > 1) {
                        var element = document.querySelector('.productQuantity');
                        element.remove(element);
                    }
                }
            }, false);
        </script>
</body>

</html>