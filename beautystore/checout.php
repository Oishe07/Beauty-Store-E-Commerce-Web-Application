<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user not logged in
    header("Location: login.php?redirect=checkout");
    exit;
}
