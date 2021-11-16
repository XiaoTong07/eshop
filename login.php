<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <?php
    include 'config/database.php';

    $id = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record user not found.');
    
    if (isset($username)) {
        $query = "SELECT username,password FROM customers WHERE username = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // var_dump($row);
        if (is_array($row)) {
            if ($password == $row['password']) {
                echo "Login successful";
            } else {
                echo "Invalid password";
            }
        }else{
            echo "User not found";
        }
    }

    ?>

</body>
</html>