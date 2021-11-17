<?php include 'session.php'; ?>

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

                // posted values
                $username = $_POST['username'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $password = $_POST['password'];
                $confirmpassword = $_POST['confirmpassword'];
                $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
                $dateofbirth = $_POST['dateofbirth'];
                $flag = 1;
                $message = "";
                $year = substr($dateofbirth, 0, 4);
                $todayyear = date("Y");
                $age = $todayyear - $year;

                if ($username == "" || $firstname == "" || $lastname == "" || $password == "" || $confirmpassword == "" || $gender == "" || $dateofbirth == "") {
                    $flag = 0;
                    $message = "Please fill in all information. ";
                }

                if (strlen($password) < 6) {
                    $flag = 0;
                    $message = $message . "Password should be at least 6 characters in length. ";
                }
                if ($password != $confirmpassword) {
                    $flag = 0;
                    $message = $message . "Password does not match. ";
                }
                if ($age < 18) {
                    $flag = 0;
                    $message = $message . "User should be 18years old or above. ";
                }

                $query = "SELECT username FROM customers WHERE username = ?";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $username);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if (is_array($row)) {
                    $flag = 0;
                    $message = $message . "User are already existed. ";
                }

                if ($flag == 1) {


                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $newpass = md5($password);
                    $stmt->bindParam(':password', $newpass);
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
                } else {
                    echo "<div class='alert alert-danger'>$message</div>";
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
                    <td>Password</td>
                    <td><input type='password' name='password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='confirmpassword' class='form-control' /></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='firstname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lastname' class='form-control' /></td>
                </tr>
                <td>Gender</td>
                <td> <input type="radio" id="female" name="gender" value="1">
                      <label for="female">Female</label>
                      <input type="radio" id="male" name="gender" value="0">
                      <label for="male">Male</label>
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
    <?php include 'footer.php'; ?>
</body>

</html>