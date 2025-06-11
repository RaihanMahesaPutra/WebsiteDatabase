<?php
session_start();
include 'koneksi.php';
$db = new Database();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $db->koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (isset($_POST['Simpan'])) {
    $db->tambah_data_agama(
        $_POST['id_agama'],
        $_POST['nama_agama']
    );
    header('location: dataagama.php');
}  
?>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tambah Data Agama</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" rel="stylesheet" />
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="../dist/css/adminlte.css" />
    
    <!-- Simple Custom Styles -->
    <style>
      body {
        background-color: #f4f6f9;
      }

      .card {
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: none;
      }

      .card-header {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
        border-radius: 12px 12px 0 0;
        padding: 1.25rem;
      }

      .card-title {
        font-weight: 600;
        margin: 0;
      }

      .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 12px;
        transition: border-color 0.3s, box-shadow 0.3s;
      }

      .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
      }

      .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
      }

      .btn {
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 500;
        transition: all 0.3s;
      }

      .btn-success {
        background: #28a745;
        border: none;
      }

      .btn-success:hover {
        background: #218838;
        transform: translateY(-1px);
      }

      .btn-secondary {
        background: #6c757d;
        border: none;
      }

      .btn-secondary:hover {
        background: #545b62;
        transform: translateY(-1px);
      }

      .callout {
        border-radius: 8px;
        border-left: 4px solid #17a2b8;
        background: #d1ecf1;
        padding: 1rem;
        margin-bottom: 1.5rem;
      }

      .app-content-header {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 1.5rem 0;
      }

      .app-content-header h3 {
        color: #495057;
        font-weight: 600;
      }

      .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
      }

      .breadcrumb-item a:hover {
        color: #28a745;
      }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <!-- Header -->
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block">
              <a href="index.php" class="nav-link">Home</a>
            </li>
          </ul>
          
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img src="../dist/assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow" alt="User Image" />
                <span class="d-none d-md-inline"><?= htmlspecialchars($user['username']) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li><hr class="dropdown-divider"></li>
                <li class="col px-3 pt-2 pb-2">
                  <div class="d-flex justify-content-between">
                    <a href="profile.php" class="btn btn-outline-secondary w-100 me-1">
                      <i class="bi bi-person-circle me-1"></i> Profile
                    </a>
                    <a href="logout.php" class="btn btn-outline-danger w-100 ms-1">
                      <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Sidebar -->
      <?php include "sidebar.php"; ?>

      <!-- Main Content -->
      <main class="app-main">
        <!-- Content Header -->
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Tambah Data Agama</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item"><a href="dataagama.php">Data Agama</a></li>
                  <li class="breadcrumb-item active">Tambah Agama</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Content -->
        <div class="app-content">
          <div class="container-fluid">
            <!-- Info Callout -->
            <div class="callout">
              <i class="bi bi-info-circle me-2"></i>
              <strong>Catatan:</strong> Mohon isi data dengan huruf kapital yang sesuai.
            </div>

            <!-- Form Card -->
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title">
                      <i class="bi bi-plus-circle me-2"></i>
                      Formulir Data Agama
                    </h5>
                  </div>
                  <div class="card-body p-4">
                    <form method="POST" class="needs-validation" novalidate>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label for="id_agama" class="form-label">Kode Agama</label>
                          <input 
                            type="text" 
                            class="form-control" 
                            id="id_agama" 
                            name="id_agama" 
                            placeholder="Contoh: 1"
                            required 
                          />
                          <div class="invalid-feedback">
                            Kode agama harus diisi.
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="nama_agama" class="form-label">Nama Agama</label>
                          <input 
                            type="text" 
                            class="form-control" 
                            id="nama_agama" 
                            name="nama_agama" 
                            placeholder="Contoh: Islam"
                            required 
                          />
                          <div class="invalid-feedback">
                            Nama agama harus diisi.
                          </div>
                        </div>
                      </div>
                      
                      <div class="mt-4">
                        <button type="submit" name="Simpan" class="btn btn-success me-2">
                          <i class="bi bi-check-lg me-1"></i> Simpan Data
                        </button>
                        <a href="dataagama.php" class="btn btn-secondary">
                          <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

      <!-- Footer -->
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">Admin Panel</div>
        <strong>&copy; 2024 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
      </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="../dist/js/adminlte.js"></script>

    <!-- Form Validation -->
    <script>
      (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
          form.addEventListener('submit', e => {
            if (!form.checkValidity()) {
              e.preventDefault();
              e.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      })();
    </script>
</body>
</html>