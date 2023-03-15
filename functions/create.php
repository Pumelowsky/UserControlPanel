<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
} else {
    require "connect.php";
    $conn = db_con();

    if (isset($_POST['send'])) {
        //POST DATA
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);

        //hash password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $firstname = $conn->real_escape_string($_POST['first']);
        $lastname = $conn->real_escape_string($_POST['last']);
        $birth = strtotime($_POST['birth']);
        $birth = date("Y-m-d", $birth);
        if (isset($_POST['groups']))
            $groups = implode(', ', $_POST['groups']);
        else
            $groups = "0";

        //Check if user exist
        $q = "SELECT * FROM users WHERE username='" . $username . "'";
        $result = $conn->query($q);
        if ($result->num_rows > 0) {
            echo "Sorry user already exists.";
        } else {
            //Insert user in MySQL DB
            $q = "INSERT INTO users(username,passwd,first_name,last_name,birthdate,groups,type) VALUES ('$username','$password','$firstname','$lastname','$birth','$groups', 0)";
            if ($conn->query($q))
                header("Location: ../dashboard.php");
            else
                echo "Error while adding user!";
        }

    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Creating new user</title>
        <link rel="stylesheet" href="../css/main.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

    <body>
        <div class="wrapper">
            <div id="formContent">
                <h1>Create new user</h1>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="first">First name</label>
                        <input type="text" class="form-control" name="first" id="first" placeholder="John" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="last">Last name</label>
                        <input type="text" class="form-control" name="last" id="last" placeholder="Doe" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="birth">Birth date</label>
                        <input type="date" class="form-control" name="birth" id="birth">
                    </div>
                    <div class="form-group">
                        <label for="groups">Groups</label>
                        <select multiple class="form-control" name="groups[ ]">
                            <?php
                            $q = "SELECT * FROM groups";
                            $result = $conn->query($q);

                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['g_id'] . "'>" . $row['name'] . "</option>";
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <button class="btn btn-success" type="submit" name="send">Create User</button>
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