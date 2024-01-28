<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
} else {
    if ($_SESSION['acc_type'] != 1) header("Location: ../dashboard.php");
    require "connect.php";
    $conn = db_con();

    if (isset($_POST['send'])) {
        //POST DATA
        $name = $conn->real_escape_string($_POST['name']);
        $color = ltrim($conn->real_escape_string($_POST['color']), "#");



        //Check if user exist
        $q = "SELECT * FROM groups WHERE name='" . $name . "'";
        $result = $conn->query($q);
        if ($result->num_rows > 0) {
            echo "Sorry group already exists.";
        } else {
            //Insert user in MySQL DB
            $q = "INSERT INTO groups(name,color) VALUES ('$name','$color')";
            if ($conn->query($q))
                header("Location: ../dashboard.php");
            else
                echo "Error while adding group!";
        }

    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Creating new group</title>
        <link rel="stylesheet" href="../css/main.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

    <body>
        <div class="wrapper">
            <div id="formContent">
                <h1>Create new group</h1>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="Name" placeholder="Name" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="color" class="form-control" name="color" id="color" value="#000000">
                    </div>

                    <button type="submit" name="send" class="btn btn-success">Create group</button>
                </form>
            </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

    </html>
<?php } ?>