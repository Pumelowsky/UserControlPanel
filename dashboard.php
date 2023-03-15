<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: index.php");
} else {
  require "functions/connect.php";
  $conn = db_con();
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <button class="navbar-toggler d-md-none" type="button" data-toggle="collapse" data-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="true" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand col-md-2 mr-0 d-none d-md-block" href="#">Panel</a>
      <ul class="navbar-nav d-none d-md-block px-1">
        <li class="nav-item text-nowrap col-sm-12">
          <a class="nav-link" href="functions/logout.php">Sign out</a>
        </li>
      </ul>

    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 col-sm-12 d-none d-md-block navbar-collapse bg-light sidebar collapse show">

          <div class="sidebar-collapse sidebar-sticky">

            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" data-id='home' href="#">
                  <i class="fa fa-home" aria-hidden="true"></i>
                  Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" data-id='users'>
                  <i class="fa fa-user" aria-hidden="true"></i>
                  Users
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" data-id='groups'>
                  <i class="fa fa-group" aria-hidden="true"></i>
                  Groups
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <nav class="col-md-2 col-sm-12 d-md-none navbar-sticky navbar-collapse bg-light sidebar collapse"
          id="navbarToggler">
          <div class="sidebar-collapse sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item col-sm-12">
                <a class="nav-link active" data-id='home' href="#">
                  <i class="fa fa-home" aria-hidden="true"></i>
                  Dashboard
                </a>
              </li>
              <li class="nav-item col-sm-12">
                <a class="nav-link" href="#" data-id='users'>
                  <i class="fa fa-user" aria-hidden="true"></i>
                  Users
                </a>
              </li>
              <li class="nav-item col-sm-12">
                <a class="nav-link" href="#" data-id='groups'>
                  <i class="fa fa-group" aria-hidden="true"></i>
                  Groups
                </a>
              </li>
              <a class="nav-link col-sm-12" href="functions/logout.php">
                <i class="fa fa-power-off" aria-hidden="true"></i>
                Sign out
              </a>
            </ul>
          </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="sites">
            <div id="home" class="m-1">
              <h3>Welcome back
                <span class="text-primary">
                  <?php echo $_SESSION['firstname'] ?>
                  <?php echo $_SESSION['lastname'] ?>
                </span>
              </h3>
              <?php
              $q = "SELECT * FROM groups";
              $result = $conn->query($q);
              $gp_count = $result->num_rows;
              $q = "SELECT * FROM users";
              $result = $conn->query($q);
              $usr_count = $result->num_rows;

              ?>
              <div class="row ml-sm-auto p-1">
                <div class="col-xs-6 col-md-6 col-lg-3">
                  <div class="card text-white bg-primary m-1">
                    <div class="card-header"><i class="fa fa-user" aria-hidden="true"></i> Current users count:</div>
                    <div class="card-body">
                      <h3 class="card-title text-center">
                        <?= $usr_count ?>
                      </h3>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-md-6 col-lg-3">
                  <div class="card text-white bg-success m-1">
                    <div class="card-header"><i class="fa fa-group" aria-hidden="true"></i> Current groups count:</div>
                    <div class="card-body">
                      <h3 class="card-title text-center">
                        <?= $gp_count ?>
                      </h3>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-md-6 col-lg-3">
                  <div class="card text-white bg-danger m-1">
                    <div class="card-header"><i class="fa fa-calendar" aria-hidden="true"></i> Today is:</div>
                    <div class="card-body">
                      <h3 class="card-title text-center">
                        <?= date("Y-m-d") ?>
                      </h3>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-md-6 col-lg-3">
                  <div class="card text-white bg-warning m-1">
                    <div class="card-header"><i class="fa fa-info" aria-hidden="true"></i> Time:</div>
                    <div class="card-body">
                      <h3 class="card-title text-center" id="timeClock">00:00:00</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="users">
              <?php include_once("site/user_list.php") ?>
            </div>
            <div id="groups">
              <?php include_once("site/group_list.php") ?>
            </div>
          </div>
        </main>
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
    <script src="js/dash.js"></script>
    <script src="js/time.js"></script>
  </body>

  </html>
  <?php
  $conn->close();
}
?>