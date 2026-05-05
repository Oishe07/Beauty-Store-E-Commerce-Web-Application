<?php
include("includes/db.php");
$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['name'];
  $mobile = $_POST['mobile'];
  $password = md5($_POST['password']);  // using md5 now

  $stmt = $conn->prepare("INSERT INTO users (name, mobile, password, role) VALUES (?, ?, ?, 'customer')");
  $stmt->bind_param("sss", $name, $mobile, $password);

  if ($stmt->execute()) {
    $msg = "Registration successful. You can now <a href='login.php'>login</a>.";
  } else {
    $msg = "Error: " . $stmt->error;
  }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
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
    <h3 class="text-center">Register</h3>
    <?php if ($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>
    <form method="post">
      <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>
      <input type="text" name="mobile" class="form-control mb-3" placeholder="Mobile Number" required>
      <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
      <button type="submit" class="btn gradient-btn w-100">Signup</button>
    </form>
    <p class="mt-3 text-center">Already a member? <a href="login.php">Login</a></p>
  </div>
</body>
</html>

