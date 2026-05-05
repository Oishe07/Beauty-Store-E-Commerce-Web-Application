<?php
session_start();
include("../includes/db.php");
include("auth_check.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    // Delete image file
    $res = $conn->query("SELECT image FROM products WHERE id=$id");
    if ($res->num_rows) {
        $img = $res->fetch_assoc()['image'];
        @unlink("../uploads/" . $img);
    }
    $conn->query("DELETE FROM products WHERE id=$id");
}

header("Location: products.php");
exit;
