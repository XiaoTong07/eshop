<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Read</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
        <?php
        include 'config/database.php';
        $query = "SELECT id , name FROM category ORDER BY id DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        $numcategory = $stmt->rowCount();

        if ($numcategory > 0) {
            echo"<select class='form-select' aria-label='Default select example' name='category'>";
            echo"<option>All</option>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<option value=$id ";
                if($id=='3'){
                    echo"selected";
                }
                echo ">";
                echo "{$name}";
                echo "</option>";
            }
            echo "</select>";
        }
        ?>
        
</body>

</html>