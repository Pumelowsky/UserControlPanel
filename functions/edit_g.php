<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
} else {
    require "connect.php";
    if (isset($_POST['id'])) {

        $conn = db_con();
        $q = "SELECT * FROM groups WHERE g_id=" . $_POST['id'];

        $result = $conn->query($q);

        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $color = $row['color'];
        }

        $conn->close();
    }
    if (isset($_POST['edit'])) {
        $conn = db_con();
        //data from form
        $id = $_POST['iid'];
        $name_ = $conn->real_escape_string($_POST['name']);
        $clr = ltrim($_POST['color'], "#"); // remove # from hex code

        $q = "UPDATE groups SET name='$name_', color='$clr' WHERE g_id='$id'";

        if ($conn->query($q))
            header("Location: ../dashboard.php");
        else
            echo "Error!";

        $conn->close();
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>User Management</title>
        <link rel="stylesheet" href="../css/main.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

    <body>
        <div class="wrapper">
            <div id="formContent">
                <h1>Edit Group</h1>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" maxlength="255" name="name" value=<?= $name ?>>
                    </div>
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="color" class="form-control" name="color" value="#<?= $color ?>">
                    </div>

                    <input type="hidden" name="iid" value=<?= $_POST['id'] ?>>
                    <button type="submit" name="edit" class="btn btn-success">Confirm</button>
                </form>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    </body>

    </html>
<?php } ?>