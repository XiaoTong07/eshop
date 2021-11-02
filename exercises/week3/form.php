<!DOCTYPE html>
<html>

<head>
    <title>form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    
    <?php
    if ($_GET) {
        echo $_GET["fname"];
        echo "</br>";
        echo $_GET["lname"];
        echo "</br>";
        echo $_GET["hobby"];
    }
    ?>

    <div class="mb-3 px-3 py-2">
        <h2>HTML FORM</h2>
    </div>

    <form action="form.php" method="get">
        <div class="input-group mb-3 px-3 ">
            <span class="input-group-text" id="fname">First Name</span>
            <input type="text" class="form-control" name="fname" aria-label="fname" aria-describedby="inputGroup-sizing-default">
        </div>
        <br>
        <div class="input-group mb-3 px-3">
            <span class="input-group-text" id="lname">Last Name</span>
            <input type="text" class="form-control" name="lname" aria-label="lname" aria-describedby="inputGroup-sizing-default">
        </div>
        <br>
        <div class="input-group mb-3 px-3">
            <span class="input-group-text" id="hobby">Hobby</span>
            <select class="form-select form-select-lg px-3" name="hobby" aria-label="hobby">
                <option selected>Select your hobby</option>
                <option value="Reading">Reading</option>
                <option value="Gaming">Gaming</option>
                <option value="Fishing">Fishing</option>
            </select>
            <br>
        </div>
        <div class="px-3 py-2">
            <input type="submit" class="btn px-3 py-2 btn-primary" value="Submit">
        </div>
    </form>

</body>

</html>