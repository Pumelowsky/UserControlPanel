<h3>List of all groups:</h3>
<?php if ($_SESSION['acc_type'] == 1) { ?>
<a href="./functions/create_g.php">
    <button type="submit" class="btn btn-primary m-2"><i class="fa fa-plus" aria-hidden="true"></i> Create new
        group</button>
</a>
<?php } ?>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>USERS IN GROUP</th>
                <th>OPTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $q = "SELECT * FROM groups";
            $result = $conn->query($q);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>";
                echo $row['g_id'];
                echo "</td>";
                echo "<td>";
                echo $row['name'];
                echo " <span class='badge' style='background-color: #" . $row['color'] . ";'>GROUP</span>";
                echo "</td>";
                echo "<td>";
                //users in group
                $q = "SELECT first_name, last_name, groups FROM users";
                $r = $conn->query($q);
                $grp_arr = array();
                while ($row2 = $r->fetch_row()) {
                    $grps = explode(",", $row2[2]);
                    for ($i = 0; $i < count($grps); $i++) {
                        if ($grps[$i] == $row['g_id']) {
                            $nameStr = $row2[0] . " " . $row2[1];
                            array_push($grp_arr, $nameStr);
                        }

                    }
                }
                echo implode(", ", $grp_arr);
                echo "</td>";
                echo "<td class='d-flex'>";
                if ($_SESSION['acc_type'] == 1) {
                    echo "<form class='m-1' method='post' action='functions/delete_g.php'><button type='submit' class='btn btn-danger'>Delete</button><input type='hidden' name='id' value='" . $row['g_id'] . "'/></form>";
                    echo "<form class='m-1' method='post' action='functions/edit_g.php'><button type='submit' class='btn btn-warning'>Edit</button><input type='hidden' name='id' value='" . $row['g_id'] . "'/></form>";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>