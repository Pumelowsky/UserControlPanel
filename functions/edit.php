<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
} else {
    if ($_SESSION['acc_type'] != 1) header("Location: ../dashboard.php");
    require "connect.php";
    if (isset($_POST['id'])) {

        $conn = db_con();
        $q = "SELECT * FROM users WHERE id=" . $_POST['id'];

        $result = $conn->query($q);

        while ($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $passwd = $row['passwd'];
            $firstname = $row['first_name'];
            $lastname = $row['last_name'];
            $birth = $row['birthdate'];
        }

        $conn->close();
    }
    if (isset($_POST['edit'])) {
        $conn = db_con();

        //data from form
        $id = $_POST['iid'];
        $uname = $conn->real_escape_string($_POST['username']);
        $pass = $conn->real_escape_string($_POST['passwd']);
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $fname = $conn->real_escape_string($_POST['firstname']);
        $lname = $conn->real_escape_string($_POST['lastname']);
        $birthdate = strtotime($_POST['birth']);
        $birthdate = date('Y-m-d', $birthdate);
        if (isset($_POST['groups']))
            $groups = implode(', ', $_POST['groups']);
        else
            $groups = "0";

        if ($_POST['password'] == "") {
            $q = "UPDATE users SET username='$uname', first_name='$fname', last_name='$lname', birthdate='$birthdate', groups='$groups' WHERE id='$id'";
        } else {
            $q = "UPDATE users SET username='$uname', passwd='$pass', first_name='$fname', last_name='$lname', birthdate='$birthdate', groups='$groups' WHERE id='$id'";
        }

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
                <h1>Edit user</h1>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" maxlength="255" value=<?= $username ?>>
                    </div>
                    <div class="form-group">
                        <label for="passwd">Pasword</label>
                        <input type="password" class="form-control" maxlength="255" name="passwd" aria-describedby="helpId"
                            value="">
                        <p class="form-text text-muted">
                            Leave blank if you don't want to change
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Firstname</label>
                        <input type="text" class="form-control" name="firstname" maxlength="255" value=<?= $firstname ?>>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control" name="lastname" maxlength="255" value=<?= $lastname ?>>
                    </div>
                    <div class="form-group">
                        <label for="birth">Birth date</label>
                        <input type="date" class="form-control" name="birth" value=<?= $birth ?>>
                    </div>
                    <div class="form-group">
                        <label for="groups">Groups:</label>
                        <select multiple class="form-control" name="groups[ ]" id="grps">
                            <?php
                            $conn = db_con();

                            $q = "SELECT * FROM groups";
                            $result = $conn->query($q);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['g_id'] . "'>" . $row['name'] . "</option>";
                            }

                            $conn->close();
                            ?>
                        </select>
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