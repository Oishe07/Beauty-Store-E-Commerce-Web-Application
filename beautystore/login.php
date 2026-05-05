<?php
include("includes/db.php");
session_start();
$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['name'];
  $password = md5($_POST['password']);  // md5 here too

  $stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
  $stmt->bind_param("s", $name);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if ($password == $user['password']) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];

      // role-based redirect
      if ($user['role'] == 'admin') {
        header("Location: admin/dashboard.php");
      } else {
        header("Location: index.php");
      }
      exit;
    } else {
      $msg = "Incorrect password.";
    }
  } else {
    $msg = "No user found with this name.";
  }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .form-box {
      max-width: 400px;
      margin: 100px auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
    }
    .gradient-btn {
      background: linear-gradient(to right, #7b2ff7, #f107a3);
      color: white;
      border: none;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h3 class="text-center">Login Form</h3>
    <?php if ($msg) echo "<div class='alert alert-danger'>$msg</div>"; ?>
    <form method="post">
      <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
      <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
      <button type="submit" class="btn gradient-btn w-100">Login</button>
    </form>
    <p class="mt-3 text-center">Not a member? <a href="register.php">Signup now</a></p>
  </div>
</body>
</html>
