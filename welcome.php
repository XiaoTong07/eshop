<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Welcome</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="menu">
        <?php include 'navigationbar.php'; ?>
    </div>
    <div class="text-center">
        <?php
        echo "Today Date: ";
        echo date("M j, Y");
        echo "<br>";
        echo "Welcome";

        include 'config/database.php';

        $proid = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record user not found.');

        $query = "SELECT username, lastname, gender FROM customers where username=?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $proid);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $lastname = $row['lastname'];
        $gender = $row['gender'];

        if ($gender = 1) {
            echo " Ms ";
        } else {
            echo " Mr ";
        };
        echo ucfirst(strtolower($lastname));
        echo "<br>";
        ?>
    </div>
    <div class="container px-4">
        <div class="row gx-1">
            <div class="col text-center border bg-light">
                <p class="fw-bold text-uppercase">Total Order</p>
                <?php
                $query = "SELECT * FROM orders ORDER BY id DESC";
                $stmt = $con->prepare($query);
                $stmt->execute();

                // this is how to get number of rows returned
                $num = $stmt->rowCount();

                if ($num > 0) {
                    echo $num;
                }

                echo "<br>";
                ?>
            </div>
            <div class="col text-center border bg-light">
                <p class="fw-bold text-uppercase">Total Product</p>
                <?php
                $query = "SELECT * FROM products ORDER BY id DESC";
                $stmt = $con->prepare($query);
                $stmt->execute();

                // this is how to get number of rows returned
                $num = $stmt->rowCount();

                if ($num > 0) {
                    echo $num;
                }

                echo "<br>";
                ?>

            </div>
            <div class="col text-center border bg-light">
                <p class="fw-bold text-upperca">Total Customer</p>
                <?php
                $query = "SELECT * FROM customers ORDER BY username DESC";
                $stmt = $con->prepare($query);
                $stmt->execute();

                // this is how to get number of rows returned
                $num = $stmt->rowCount();

                if ($num > 0) {
                    echo $num;
                }
                ?>
            </div>
        </div>
        <?php
            $query = "SELECT id,customer,orderdateandtime FROM orders ORDER BY orderdateandtime DESC";
            $stmt = $con->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //var_dump($row);

            // values to fill up our form
            $id = $row['id'];
            $customer = $row['customer'];
            $orderdateandtime = $row['orderdateandtime'];

            $totalquery = "SELECT orderdetailsid,order_id,product_id,quantity, products.id ,products.price as proprice, products.name as proname FROM orderdetails INNER JOIN products ON orderdetails.product_id = products.id WHERE order_id = ?";
            $stmt = $con->prepare($totalquery);

            // this is the first question mark
            $stmt->bindParam(1, $proid);

            // execute our query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalamount =0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $total = ($proprice * $quantity);
                $totalamount=$totalamount+$total;
            }

            $totalamount = $totalamount;

        ?>
        <div class="container px-4">
            <div class="row gx-5">
                <div class="col">
                    <div class="p-3 border bg-light">
                        <h3>Latest Order</h3>
                        <div class='col-5'>Order ID : </td>
                            <td class='col-6'><?php echo $id ?>
                        </div>
                        <div class='col-5'>Customer Name : </td>
                            <td class='col-6'><?php echo $customer ?>
                        </div>
                        <div class='col-5'>Total Amount : </td>
                            <td class='col-6'><?php echo $totalamount?>
                        </div>
                        <div class='col-5'>Order Date : </td>
                            <td class='col-6'><?php echo $orderdateandtime ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'footer.php'; ?>
</body>

</html>

