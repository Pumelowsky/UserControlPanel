<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
} else {
    if (isset($_POST['id'])) {
        if ($_SESSION['acc_type'] != 1) header("Location: ../dashboard.php");
        require "connect.php";
        $conn = db_con();
        $q = "DELETE FROM groups WHERE g_id=" . $_POST['id'];
        if ($conn->query($q)) {
            header("Location: ../dashboard.php?success=1");
        } else {
            header("Location: ../dashboard.php?success=0");
        }

        $conn->close();
    }
    header("Location: ../dashboard.php");
}
?>