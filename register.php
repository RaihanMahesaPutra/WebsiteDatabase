<?php
session_start();
include "koneksi.php";
$db = new database();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi password
    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi tidak sama!";
    } else {
        // Cek username
        $check_username = $db->koneksi->query("SELECT * FROM users WHERE username = '$username'");
        if ($check_username->num_rows > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Cek email
            $check_email = $db->koneksi->query("SELECT * FROM users WHERE email = '$email'");
            if ($check_email->num_rows > 0) {
                $error = "Email sudah digunakan!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
                if ($db->koneksi->query($query)) {
                    $success = "Registrasi berhasil! Silakan login.";
                } else {
                    $error = "Registrasi gagal: " . $db->koneksi->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi - Admin Panel</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .register-box {
      max-width: 450px;
      margin: 60px auto;
    }
    .register-logo a {
      font-size: 28px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="register-box">
    <div class="register-logo mb-4 text-center">
      <a href="index.php"><b>Admin</b>Panel</a>
    </div>

    <div class="card shadow-sm">
      <div class="card-body register-card-body">
        <p class="text-center mb-4">Daftar akun baru</p>

        <?php if (isset($error)): ?>
          <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
          <div class="alert alert-success text-center"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="post">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              <input type="email" class="form-control" name="email" placeholder="Email aktif" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password" required>
              <span class="input-group-text" onclick="togglePassword('password', 'toggleIcon1')" style="cursor: pointer;">
                <i class="fas fa-eye" id="toggleIcon1"></i>
              </span>
            </div>
          </div>

          <div class="mb-5">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Ulangi password" required>
              <span class="input-group-text" onclick="togglePassword('confirm_password', 'toggleIcon2')" style="cursor: pointer;">
                <i class="fas fa-eye" id="toggleIcon2"></i>
              </span>
            </div>
          </div>

          <div class="d-grid">
            <button type="submit" name="register" class="btn btn-primary">Daftar</button>
          </div>
        </form>

        <div class="mt-3 text-center">
          <a href="login.php">Sudah punya akun? Login di sini</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE -->
  <script src="dist/js/adminlte.min.js"></script>
  <script>
    function togglePassword(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    }
    </script>
</body>
</html>
