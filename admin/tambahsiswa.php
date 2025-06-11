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

$jurusan = $db->tampil_data_jurusan();
$agama = $db->tampil_data_agama();

if (isset($_POST['Simpan'])) {
    $db->tambah_data_siswa(
        $_POST['nisn'],
        $_POST['nama'],
        $_POST['jeniskelamin'],
        $_POST['kodejurusan'],
        $_POST['kelas'],
        $_POST['alamat'],   
        $_POST['agama'],
        $_POST['nohp']      
    );
    header('location: datasiswa.php'); 
}   
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sistem Informasi Akademik | Tambah Data Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Sistem Informasi Akademik untuk manajemen data siswa" />
    
    <!-- Fonts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    
    <!-- OverlayScrollbars -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    
    <!-- Bootstrap Icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    
    <!-- AdminLTE -->
    <link rel="stylesheet" href="../dist/css/adminlte.css" />
    
    <!-- Custom CSS -->
    <style>
      /* Form styling */
      .form-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 30px;
      }
      
      .form-header {
        border-bottom: 1px solid #e0e0e0;
        margin-bottom: 25px;
        padding-bottom: 15px;
      }
      
      .form-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 0;
      }
      
      .form-group {
        margin-bottom: 20px;
      }
      
      .form-label {
        color: #4b5563;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
      }
      
      .form-control {
        border: 1px solid #d1d5db;
        border-radius: 6px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        padding: 10px 16px;
        width: 100%;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      }
      
      .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        outline: none;
      }
      
      .gender-group {
        display: flex;
        gap: 20px;
        margin-top: 10px;
      }
      
      .gender-option {
        display: flex;
        align-items: center;
        cursor: pointer;
      }
      
      .gender-option input {
        margin-right: 8px;
      }
      
      .submit-btn {
        background-color: #0d6efd;
        border: none;
        border-radius: 6px;
        color: white;
        cursor: pointer;
        font-weight: 500;
        padding: 12px 24px;
        transition: background-color 0.15s ease-in-out;
      }
      
      .submit-btn:hover {
        background-color: #0b5ed7;
      }
      
      .form-footer {
        margin-top: 30px;
        display: flex;
        justify-content: flex-end;
      }
      
      /* Required field indicator */
      .required::after {
        content: " *";
        color: #ef4444;
      }
      
      /* Card styling */
      .custom-card {
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
      }
      
      .custom-card-header {
        background-color: #0d6efd;
        color: white;
        padding: 15px 20px;
        border-bottom: none;
      }
      
      /* Responsive adjustments */
      @media (max-width: 768px) {
        .form-container {
          padding: 20px;
        }
      }
    </style>
  </head>
  
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="index.php" class="nav-link">Home</a></li>
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="../dist/assets/img/user2-160x160.jpg"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline"><?= htmlspecialchars($user['username']) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            
                <li><hr class="dropdown-divider"></li>

                <!-- Menu Footer -->
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
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <?php include "sidebar.php"; ?>
      
      <!-- Main Content -->
      <main class="app-main">
        <!-- Content Header -->
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Tambah Data Siswa</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item"><a href="datasiswa.php">Data Siswa</a></li>
                  <li class="breadcrumb-item active">Tambah Siswa</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Main Content -->
        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="custom-card card">
                  <div class="custom-card-header">
                    <h3 class="card-title mb-0">
                      <i class="bi bi-person-plus-fill me-2"></i>Form Tambah Siswa Baru
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="form-container">
                      <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Pastikan data yang dimasukkan sudah benar sebelum menyimpan.
                      </div>
                    
                      <form action="" method="post" class="needs-validation" novalidate>
                        <div class="row">
                          <!-- NISN Field -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="nisn" class="form-label required">NISN</label>
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="bi bi-hash"></i>
                                </span>
                                <input 
                                  type="text" 
                                  class="form-control" 
                                  id="nisn" 
                                  name="nisn" 
                                  placeholder="Masukkan NISN" 
                                  maxlength="10"
                                  required
                                >
                              </div>
                              <div class="form-text">Nomor Induk Siswa Nasional (10 digit)</div>
                            </div>
                          </div>
                          
                          <!-- Nama Field -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="nama" class="form-label required">Nama Lengkap</label>
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="bi bi-person"></i>
                                </span>
                                <input 
                                  type="text" 
                                  class="form-control" 
                                  id="nama" 
                                  name="nama" 
                                  placeholder="Masukkan Nama Lengkap" 
                                  required
                                >
                              </div>
                            </div>
                          </div>
                          
                          <!-- Jenis Kelamin Field -->
                          <div class="col-md-6 mt-3">
                            <div class="form-group">
                              <label class="form-label required">Jenis Kelamin</label>
                              <div class="gender-group">
                                <label class="gender-option">
                                  <input type="radio" name="jeniskelamin" value="L" required> Laki-laki
                                </label>
                                <label class="gender-option">
                                  <input type="radio" name="jeniskelamin" value="P" required> Perempuan
                                </label>
                              </div>
                            </div>
                          </div>
                          
                          <!-- Jurusan Field -->
                          <div class="col-md-6 mt-3">
                            <div class="form-group">
                              <label for="kodejurusan" class="form-label required">Jurusan</label>
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="bi bi-book"></i>
                                </span>
                                <select 
                                  class="form-control form-select" 
                                  id="kodejurusan" 
                                  name="kodejurusan" 
                                  required
                                >
                                  <option value="" disabled selected>-- Pilih Jurusan --</option>
                                  <?php foreach ($jurusan as $j) : ?>
                                      <option value="<?= $j['kodejurusan']; ?>"><?= $j['namajurusan']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          
                          <!-- Kelas Field -->
                          <div class="col-md-6 mt-3">
                            <div class="form-group">
                              <label for="kelas" class="form-label required">Kelas</label>
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="bi bi-diagram-3"></i>
                                </span>
                                <select class="form-control form-select" id="kelas" name="kelas" required>
                                  <option value="" disabled selected>-- Pilih Kelas --</option>
                                  <option value="X">X (Sepuluh)</option>
                                  <option value="XI">XI (Sebelas)</option>
                                  <option value="XII">XII (Dua Belas)</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          
                          <!-- Agama Field -->
                          <div class="col-md-6 mt-3">
                            <div class="form-group">
                              <label for="agama" class="form-label required">Agama</label>
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="bi bi-building"></i>
                                </span>
                                <select 
                                  class="form-control form-select" 
                                  id="agama" 
                                  name="agama" 
                                  required
                                >
                                  <option value="" disabled selected>-- Pilih Agama --</option>
                                  <?php foreach ($agama as $a) : ?>
                                    <option value="<?= $a['id_agama']; ?>"><?= $a['nama_agama']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          
                          <!-- No HP Field -->
                          <div class="col-md-6 mt-3">
                            <div class="form-group">
                              <label for="nohp" class="form-label required">No. Handphone</label>
                              <div class="input-group">
                                <span class="input-group-text">
                                  <input 
                                    type="text" 
                                    class="form-control" 
                                    id="no_telp" 
                                    name="no_telp" 
                                    placeholder="Masukkan No Telepon" 
                                    maxlength="13" 
                                    required
                                  >
                                  <i class="bi bi-phone"></i>
                                </span>
                              </div>
                            </div>
                          </div>
                          
                          <!-- Alamat Field -->
                          <div class="col-md-12 mt-3">
                            <div class="form-group">
                              <label for="alamat" class="form-label required">Alamat Lengkap</label>
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="bi bi-geo-alt"></i>
                                </span>
                                <textarea 
                                  class="form-control" 
                                  id="alamat" 
                                  name="alamat" 
                                  rows="3" 
                                  placeholder="Masukkan Alamat Lengkap" 
                                  required
                                ></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="form-footer mt-4">
                          <div class="row">
                            <div class="col-auto">
                              <a href="datasiswa.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                              </a>
                              <button type="submit" name="Simpan" class="btn btn-primary submit-btn">
                                <i class="bi bi-save me-1"></i> Simpan Data
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      
      <!-- Footer -->
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">
          <strong>Version</strong> 1.0.0
        </div>
        <strong>
          Copyright &copy; 2024
          <a href="#" class="text-decoration-none">Sistem Informasi Akademik</a>.
        </strong>
        All rights reserved.
      </footer>
    </div>
    
    <!-- Scripts -->
    <!-- OverlayScrollbars -->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    
    <!-- Popper.js -->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    
    <!-- Bootstrap -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    
    <!-- AdminLTE -->
    <script src="../dist/js/adminlte.js"></script>
    
    <!-- Form validation script -->
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function () {
        'use strict'
        
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
          .forEach(function (form) {
            form.addEventListener('submit', function (event) {
              if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
              }
              
              form.classList.add('was-validated')
            }, false)
          })
      })()
    </script>
    
    <!-- OverlayScrollbars Configure -->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
      document.getElementById('nisn').addEventListener('input', function () {
    // Hapus semua karakter non-angka, lalu potong maksimal 10 digit
    this.value = this.value.replace(/\D/g, '').slice(0, 10);
  });
  document.getElementById('no_telp').addEventListener('input', function () {
    // Hapus semua karakter non-angka, lalu potong maksimal 13 digit
    this.value = this.value.replace(/\D/g, '').slice(0, 13);
  })
    </script>
  </body>
</html>