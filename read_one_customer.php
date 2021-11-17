<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Read One</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="menu">
        <?php include 'navigationbar.php'; ?>
    </div>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Customer</h1>
        </div>

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record user not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT username,password,firstname,lastname,gender,dateofbirth,registrationdateandtime,accountstatus FROM customers WHERE username = ?";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $username = $row['username'];
            $password = $row['password'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $gender = $row['gender'];
            $dateofbirth = $row['dateofbirth'];
            $registrationdateandtime = $row['registrationdateandtime'];
            $accountstatus = $row['accountstatus'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>


        <!--we have our html table here where the record will be displayed-->
        <table class=' table table-hover table-responsive table-bordered'>
            <tr>
                <td>Username</td>
                <td><?php echo htmlspecialchars($username, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><?php echo htmlspecialchars($password, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td><?php echo htmlspecialchars($firstname, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?php echo htmlspecialchars($lastname, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td><?php echo htmlspecialchars($gender != 1 ? 'Male' : 'Female', ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Date Of Birth</td>
                <td><?php echo htmlspecialchars($dateofbirth, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Registration Date And Time</td>
                <td><?php echo htmlspecialchars($registrationdateandtime, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Account Status</td>
                <td><?php echo htmlspecialchars($accountstatus, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='customerlist.php' class='btn btn-danger'>Back to read customers</a>
                </td>
            </tr>
        </table>

    </div> <!-- end.container -->
    <?php include 'footer.php'; ?>
</body>

</html>