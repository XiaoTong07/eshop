<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

</head>

<body>
    <?php
    session_start();

    if ($_POST) {
        include 'config/database.php';

        $username = htmlspecialchars(strip_tags($_POST['username']));
        $password = htmlspecialchars(strip_tags($_POST['password']));
        $flag = 1;
        $message = "";

        if ($username == "" || $password == "") {
            $flag = 0;
            $message = "Please fill in all information. ";
        }

        if ($flag == 1) {
            $query = "SELECT username, password, accountstatus FROM customers WHERE username = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $username);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (is_array($row)) {
                if (md5($password) == $row['password']) {
                    if ($row['accountstatus'] == 1) {
                        $_SESSION["username"] = $username;
                        header("location: welcome.php?username={$username}");
                        exit;
                    } else {
                        echo "<div class='alert alert-danger row justify-content-center'>Not active account</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger row justify-content-center'>wrong password</div>";
                }
            } else {
                echo "<div class='alert alert-danger row justify-content-center'>user not found</div>";
            }
        } else {
            echo "<div class='alert alert-danger row justify-content-center'>$message</div>";
        }

    }
    ?>

    <main class="justify-content-center text-center d-flex p-5 my-5">
        <div class="bg-light col-md-3 my-5 p-5">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <img class="mb-4" src="logo.png" alt="logo" width="150" height="150">
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                <div class="form-floating mb-3">
                    <input type="text" name='username' class="form-control" id="floatingInput" placeholder="username">
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name='password' class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <input type="submit" class="w-100 btn btn-lg btn-primary" value="Sign In">
                <p class="mt-5 mb-3 text-muted">© 2017–2021</p>
            </form>
        </div>
    </main>
</body>

</html>