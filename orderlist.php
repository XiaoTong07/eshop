<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Read</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="menu">
        <?php include 'navigationbar.php'; ?>
    </div>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Order</h1>
        </div>

        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $query = "SELECT id,customer,orderdateandtime FROM orders ORDER BY id DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='createorder.php' class='btn btn-primary m-b-1em'>Create New Order</a>";
        ?>

                <?php
                //check if more than 0 record found
                if ($num > 0) {

                    echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

                    //creating our table heading
                    echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Name</th>";
                    echo "<th>Order Date And Time</th>";

                    // retrieve our table contents
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // extract row
                        // this will make $row['firstname'] to just $firstname only
                        extract($row);
                        // creating new table row per record
                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$customer}</td>";
                        echo "<td>{$orderdateandtime}</td>";
                        echo "<td>";
                        // read one record
                        echo "<a href='read_one_order.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";
                        // we will use this links on next part of this post
                        echo "<a href='updateorder.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";
                        // we will use this links on next part of this post
                        echo "<a href='deleteorder.php?id={$id}' onclick='delete_user({$id});'  class='btn btn-danger'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }


                    // end table
                    echo "</table>";
                }
                // if no records found
                else {
                    echo "<div class='alert alert-danger'>No records found.</div>";
                }
                ?>


    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <?php include 'footer.php'; ?>
    <script type='text/javascript'>
        // confirm record deletion
        function delete_user(id) {

            var answer = confirm('Are you sure?');
            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'deleteorder.php?id=' + id;
            }
        }
    </script>

</body>

</html>