<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $_SESSION['user'] = $result->fetch_assoc();
        if ($_SESSION['user']['role'] == 'admin') {
            header("Location: dashboard/dosen.php");
        } else {
            header("Location: dashboard/mahasiswa.php");
        }
        exit();
    } else {
        $error = "Incorrect username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login – Skolearn</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: #f9f9f9;
      font-family: 'Poppins', sans-serif;
    }

    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
    }

    .left {
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px;
    }

    .left img {
      max-width: 100%;
      height: auto;
    }

    .form-container {
      padding: 60px 40px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      margin: auto;
    }

    .btn-login {
      background: #02b564;
      color: white;
    }

    .btn-login:hover {
      background: #029658;
    }

    .form-control:focus {
      border-color: #02b564;
      box-shadow: 0 0 0 0.2rem rgba(2, 181, 100, 0.25);
    }
  </style>
</head>
<body>

    <div class="container-fluid login-container">
    <div class="row flex-grow-1">
        <!-- Left image -->
        <div class="col-md-6 d-none d-md-flex left">
        <img src="assets/img/login.png" alt="Login Illustration" />
        </div>

        <!-- Right login form -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
        <div class="form-container">
            <h3 class="mb-4">Welcome Back 👋</h3>
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input name="username" type="text" class="form-control" required autofocus />
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-login w-100 py-2">Login</button>
            </form>
        </div>
        </div>
    </div>
    </div>

</body>
</html>
