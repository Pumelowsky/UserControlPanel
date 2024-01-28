<h3>List of all users:</h3>
<?php
$q = "SELECT * FROM users";

$result = $conn->query($q);
$num = $result->num_rows;


if ($num == 0) {
    echo "<h3>No users in database</h3>";
} else {
    if ($_SESSION['acc_type'] == 1) {
    ?>
    <a href="./functions/create.php">
        <button type="submit" class="btn btn-primary m-2"><i class="fa fa-user-plus" aria-hidden="true"></i> Create new
            user</button>
    </a>
    <?php } ?>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Birth date</th>
                    <th>Groups</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    $q = "SELECT * FROM groups";
                    $result_g = $conn->query($q);
                    $grp_arr = array();
                    while ($row_g = $result_g->fetch_row()) {
                        $grps = explode(", ", $row['groups']);
                        for ($i = 0; $i < count($grps); $i++) {
                            if ($grps[$i] == $row_g[0]) {
                                $nameStr = $row_g[1];
                                array_push($grp_arr, $nameStr);
                            }
                        }
                    }
                    echo "<tr>";
                    echo "<td>";
                    echo $row['id'];
                    echo "</td>";
                    echo "<td>";
                    echo $row['username'];
                    if ($row['type'] == 1)
                        echo " <span class='badge badge-danger'>ADMIN</span>";

                    echo "</td>";
                    echo "<td>";
                    echo $row['first_name'];
                    echo "</td>";
                    echo "<td>";
                    echo $row['last_name'];
                    echo "</td>";
                    echo "<td>";
                    echo $row['birthdate'];
                    echo "</td>";
                    echo "<td>";
                    echo implode(", ", $grp_arr);
                    echo "</td>";
                    echo "<td class='d-flex p-7'>";
                    if ($_SESSION['acc_type'] == 1) {
                        echo "<form class='m-1' method='post' action='functions/delete.php'><button type='submit' class='btn btn-danger'>Delete</button><input type='hidden' name='id' value='" . $row['id'] . "'/></form>";
                        echo "<form class='m-1'method='post' action='functions/edit.php'><button type='submit' class='btn btn-warning'>Edit</button><input type='hidden' name='id' value='" . $row['id'] . "'/></form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>