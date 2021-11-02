<!DOCTYPE HTML>
<html>

<head>
    <title>Customer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="menu">
        <?php include 'navigationbar.php'; ?>
    </div>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Customer</h1>
        </div>
        <!-- html form here where the product information will be entered -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO customers SET username=:username, password=:password, confirmpassword=:confirmpassword,firstname=:firstname,lastname=:lastname,gender=:gender,dateofbirth=:dateofbirth,registrationdateandtime=:registrationdateandtime";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                $password = md5($_POST['password']);
                $confirmpassword = md5($_POST['confirmpassword']);
                $gender = htmlspecialchars(strip_tags($_POST['gender']));
                $dateofbirth = date('Y-m-d', strtotime($_POST['dateofbirth']));

                if (empty($password || $confirmpassword)) {
                    echo "Please enter password.";
                } elseif ($password != $confirmpassword) {
                    echo "Password does not match.";
                } elseif (strlen($password) < 6) {
                    echo "Password should be at least 6 characters in length";
                } else {

                // bind the parameters
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':confirmpassword', $confirmpassword);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':dateofbirth', $dateofbirth);
                // specify when this record was inserted to the database
                $registrationdateandtime = date('Y-m-d H:i:s');
                $stmt->bindParam(':registrationdateandtime', $registrationdateandtime);
                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            }
        }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' class='form-control'></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='firstname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lastname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='password' class='form-control' minlength="6"required /></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='confirmpassword' class='form-control' minlength="6"required /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <select class="form-select form-select-sm" name='gender' aria-label="Gender">
                            <option selected>Choose Your Gender</option>
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>date of birth</td>
                    <td><input type='date' name='dateofbirth' class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='customerlist.php' class='btn btn-danger'>Back to read customer</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>