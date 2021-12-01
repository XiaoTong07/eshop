<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <?php include 'navigationbar.php'; ?>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <!-- PHP read record by ID will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $c_username = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT username, email, password, firstname, lastname, gender, dateofbirth FROM customers WHERE username = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $c_username);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $password = $row['password'];
            $email = $row['email'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $gender = $row['gender'];
            $dateofbirth = $row['dateofbirth'];


            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$c_username}</td>";
                echo "<td>{$email}</td>";
                echo "<td>{$password}</td>";
                echo "<td>{$firstname}</td>";
                echo "<td>{$lastname}</td>";
                echo "<td>{$gender}</td>";
                echo "<td>${$dateofbirth}</td>";
                echo "<td>";
                // read one record
                echo "<a href='read_one_customer.php?username={$c_username}' class='btn btn-info m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='updatecustomer.php?username={$c_username}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_user({$c_username});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }


        ?>

        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                // posted values
                $oldpassword = $_POST['oldpassword'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirmpassword = $_POST['confirmpassword'];
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                $gender = htmlspecialchars(strip_tags($_POST['gender']));
                $dateofbirth = date(strip_tags($_POST['dateofbirth']));
                $year = substr($dateofbirth, 0, 4);
                $todayyear = date("Y");
                $age = $todayyear - $year;
                $flag = 1;

                if ($firstname == "" ||$email == "" || $lastname == "" || $gender == "" || $dateofbirth == "") {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>Please fill in all information.</div> ";
                }

                if ($age < 18) {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>User should be 18years old or above.</div>";
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>Invalid email format.</div>";
                }

                $query = "SELECT email FROM customers WHERE email = ?";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $email);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if (is_array($row)) {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>Email are already existed.</div>";
                }

                if ($oldpassword == "" && $password == "" && $confirmpassword == "") {
                    if ($flag == 1) {
                        $query = "UPDATE customers SET email=:email, firstname=:firstname, lastname=:lastname, gender=:gender, dateofbirth=:dateofbirth WHERE username=:username";
                        $stmt = $con->prepare($query);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':firstname', $firstname);
                        $stmt->bindParam(':lastname', $lastname);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':dateofbirth', $dateofbirth);
                        $stmt->bindParam(':username', $c_username);

                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Record was updated.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                    }
                } else {
                    if ($password == "" || $oldpassword == "" || $confirmpassword == "") {
                        $flag = 0;
                        echo "<div class='alert alert-danger'>Please fill in all information.</div> ";
                    }
                    if (strlen($password) < 6 || strlen($oldpassword) < 6 || strlen($confirmpassword) < 6) {
                        $flag = 0;
                        echo "<div class='alert alert-danger'>Password should be at least 6 characters in length.</div> ";
                    }
                    if ($password !== $confirmpassword) {
                        $flag = 0;
                        echo "<div class='alert alert-danger'>Password does not match.</div> ";
                    }
                    if ($oldpassword == $password) {
                        $flag = 0;
                        echo "<div class='alert alert-danger'>New password should not same with old password.</div> ";
                    }

                    if ($flag == 1) {
                        $query = "SELECT username, password FROM customers WHERE username =? LIMIT 0,1";
                        $stmt = $con->prepare($query);
                        $stmt->bindParam(1, $c_username);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        if (is_array($row)) {
                            if (md5($oldpassword) !== $row['password']) {
                                $flag = 0;
                                echo "<div class='alert alert-danger'>Wrong Password.</div>";
                            } else {
                                $query = "UPDATE customers SET email=:email, password=:password, firstname=:firstname, lastname=:lastname, gender=:gender, dateofbirth=:dateofbirth WHERE username=:username";
                                $stmt = $con->prepare($query);
                                $stmt->bindParam(':email', $email);
                                $epass = md5($password);
                                $stmt->bindParam(':password', $epass);
                                $stmt->bindParam(':firstname', $firstname);
                                $stmt->bindParam(':lastname', $lastname);
                                $stmt->bindParam(':gender', $gender);
                                $stmt->bindParam(':dateofbirth', $dateofbirth);
                                $stmt->bindParam(':username', $c_username);

                                if ($stmt->execute()) {
                                    echo "<div class='alert alert-success'>Record was updated.</div>";
                                } else {
                                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                                }
                            }
                        }
                    }
                }
            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <!-- HTML form to update record will be here -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?username={$c_username}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><?php echo htmlspecialchars($c_username, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='text' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control'></td>
                </tr>
                <tr>
                    <td>Old Password</td>
                    <td><input type='password' name='oldpassword' value="" class='form-control' /></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type='password' name='password' value="" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='confirmpassword' class='form-control' /></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='firstname' value="<?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lastname' value="<?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td> <input type="radio" id="female" name="gender" value="1" <?php if (isset($gender) && $gender == "1") echo "checked" ?>>

                        <label for="female">Female</label>
                          <input type="radio" id="male" name="gender" value="0" <?php if (isset($gender) && $gender == "0") echo "checked" ?>>

                        <label for="male">Male</label>
                    </td>
                     
                </tr>

                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='dateofbirth' value="<?php echo date($dateofbirth, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customerlist.php' class='btn btn-danger'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>




    </div>
    <!-- end .container -->
</body>

</html>