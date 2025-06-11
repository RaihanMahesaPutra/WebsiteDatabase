<?php
ob_start(); // Buffer output untuk mencegah header error

session_start();
// Cek apakah session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Cek jika user sudah login, redirect ke dashboard
if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
    switch ($_SESSION['level']) {
        case 'admin':
            header("Location: admin/index.php");
            break;
        case 'guru':
            header("Location: guru/index.php");
            break;
        case 'siswa':
            header("Location: siswa/index.php");
            break;
        default:
            header("Location: unauthorized.php");
    }
    exit();
}

include "koneksi.php";
$db = new database();
  
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Gunakan prepared statement untuk mencegah SQL injection
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->koneksi->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['level'] = $user['level']; // Tambahkan level ke session
            header("Location: index.php");
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Admin Panel</title>

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- AdminLTE 4 -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f4f6f9;
    }
    .login-box {
      max-width: 400px;
      margin: 80px auto;
    }
    .login-logo a {
      font-size: 28px;
      font-weight: 600;
    }
  </style>
</head>
<body class="login-page">
  <div class="login-box">
    <div class="login-logo mb-4">
      <a href="#"><b>Admin</b>Panel</a>
    </div>

    <div class="card shadow-sm">
      <div class="card-body login-card-body">
        <p class="login-box-msg mb-4">Silakan login untuk melanjutkan</p>

        <?php if (isset($error)): ?>
          <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" name="username" placeholder="Masukkan username" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password" required>
              <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                <i class="fas fa-eye" id="toggleIcon"></i>
              </span>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input type="checkbox" id="remember" class="form-check-input">
              <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
          </div>

          <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';
      toggleIcon.classList.toggle('fa-eye');
      toggleIcon.classList.toggle('fa-eye-slash');
    }
  </script>

</body>
</html>