<?php
$alert = "info";
$state = "none";
$text = "";
$title = "";

if (isset($_POST['submit'])) {
    if (!empty($_POST["username"]) && !empty($_POST['passwd'])) {
        require "functions/connect.php";
        $conn = db_con();

        $my_username = $conn->real_escape_string($_POST['username']);
        $my_passwd = $conn->real_escape_string($_POST['passwd']);

        $q = "SELECT passwd from users WHERE username='" . $my_username . "'";

        $result = $conn->query($q);
        $num = $result->num_rows;
        if ($num == 1) {
            $pass_from_db = $result->fetch_row();
            if (password_verify($my_passwd, $pass_from_db[0])) {
                $alert = "success";
                $state = "block";
                $text = "You successfully logged in.";
                $title = "Logged in";
                $q = "SELECT * FROM users WHERE username='" . $my_username . "'";
                $result = $conn->query($q);

                if ($result->num_rows == 1) {
                    session_start();
                    $arr = $result->fetch_array();
                    $_SESSION['id'] = $arr['id'];
                    $_SESSION['username'] = $arr['username'];
                    $_SESSION['firstname'] = $arr['first_name'];
                    $_SESSION['lastname'] = $arr['last_name'];
                    $_SESSION['birthdate'] = $arr['birthdate'];
                    $_SESSION['groups'] = $arr['groups'];
                    $_SESSION['acc_type'] = $arr['type'];

                    header("Refresh:2; url=dashboard.php");
                }
            } else {
                $alert = "danger";
                $state = "block";
                $text = "You typed wrong password!";
                $title = "Error on login";
            }
        } else {
            $alert = "danger";
            $state = "block";
            $text = "There is no user with this username.";
            $title = "Error on login";
        }

        $conn->close();
    } else {
        $alert = "danger";
        $state = "block";
        $text = "Username and password cannot be blank.";
        $title = "Error on login";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Management</title>
    <link rel="stylesheet" href="./css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper">
        <div id="formContent">
            <h1>Login</h1>
            <div class="alert alert-<?= $alert ?>" role="alert" id="log_al" style="display:<?= $state ?>;">
                <h4 class="alert-heading">
                    <?= $title ?>
                </h4>
                <p>
                    <?= $text ?>
                </p>
                <p class="mb-0"></p>
            </div>
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" maxlength="255" class="form-control" placeholder=""
                        aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="passwd">Password</label>
                    <input type="password" name="passwd" id="passwd" maxlength="255" class="form-control" placeholder=""
                        aria-describedby="helpId">
                </div>
                <button type="submit" name="submit" class="btn btn-success">Login</button>
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