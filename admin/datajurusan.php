<?php
session_start();
include "koneksi.php";
$db = new database();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = $db->koneksi->query($query);
$user = $result->fetch_assoc();

// Handle form submissions
if (isset($_POST['update_jurusan'])) {
    $kodejurusan = $_POST['kodejurusan'];
    $namajurusan = $_POST['namajurusan'];
    
    $query = "UPDATE jurusan SET namajurusan = '$namajurusan' WHERE kodejurusan = '$kodejurusan'";
    if ($db->koneksi->query($query)) {
        echo "<script>alert('Data berhasil diupdate'); window.location='datajurusan.php';</script>";
    } else {
        echo "<script>alert('Gagal update data');</script>";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE 4 | Data Jurusan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Data Jurusan" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard" />
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
    
    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    
    <!-- AdminLTE -->
    <link rel="stylesheet" href="../dist/css/adminlte.css" />
    
    <!-- Custom Responsive CSS -->
    <style>
      /* Base responsive adjustments */
      .table-responsive {
        border-radius: 0.375rem;
        overflow-x: auto;
      }
      
      /* Mobile First - Extra Small devices (portrait phones, less than 576px) */
      @media (max-width: 575.98px) {
        .app-content-header .container-fluid {
          padding: 0.75rem;
        }
        
        .card-header {
          padding: 0.75rem;
          flex-direction: column !important;
          gap: 0.75rem;
        }
        
        .card-header h3 {
          margin-bottom: 0;
          text-align: center;
          font-size: 1.1rem;
        }
        
        .btn {
          font-size: 0.8rem;
          padding: 0.375rem 0.75rem;
        }
        
        .table {
          font-size: 0.8rem;
        }
        
        .table td, .table th {
          padding: 0.4rem;
          white-space: nowrap;
        }
        
        .btn-group .btn {
          padding: 0.25rem 0.5rem;
        }
        
        .modal-dialog {
          margin: 0.5rem;
        }
        
        .breadcrumb {
          font-size: 0.8rem;
          margin-bottom: 0;
        }
      }
      
      /* Small devices (landscape phones, 576px and up) */
      @media (min-width: 576px) and (max-width: 767.98px) {
        .card-header {
          flex-direction: column !important;
          gap: 1rem;
        }
        
        .card-header h3 {
          margin-bottom: 0;
          text-align: center;
        }
        
        .table {
          font-size: 0.9rem;
        }
      }
      
      /* Medium devices (tablets, 768px and up) */
      @media (min-width: 768px) and (max-width: 991.98px) {
        .card-header {
          flex-wrap: wrap;
          gap: 0.5rem;
        }
      }
      
      /* Utility classes for responsive text */
      .text-truncate-mobile {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
      }
      
      @media (min-width: 768px) {
        .text-truncate-mobile {
          max-width: none;
          white-space: normal;
          overflow: visible;
          text-overflow: clip;
        }
      }
      
      /* Button responsive adjustments */
      .btn-responsive {
        white-space: nowrap;
      }
      
      @media (max-width: 575.98px) {
        .btn-responsive .btn-text {
          display: none;
        }
      }
      
      /* Modal responsive adjustments */
      @media (max-width: 575.98px) {
        .modal-dialog-responsive {
          margin: 0.25rem;
          max-width: calc(100% - 0.5rem);
        }
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
      
      <?php include "Sidebar.php"; ?>
      
      <!-- Main Content -->
      <main class="app-main">
        <!-- Content Header -->
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="card-header">
              <h3>Data Jurusan</h3>
              <a href="tambahjurusan.php" class="btn btn-primary float-end">
                <i class="bi bi-plus-circle me-1"></i>Tambah Data
              </a>
            </div>
            
            <div class="row">
              <div class="col-12">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data Jurusan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Content -->
        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Tabel Jurusan</h3>
                  </div>
                  
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                          <tr>
                            <th scope="col">Kode Jurusan</th>
                            <th scope="col">Nama Jurusan</th>
                            <th scope="col" class="text-center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($db->tampil_data_jurusan() as $x) { ?>
                          <tr>
                            <td><?php echo htmlspecialchars($x['kodejurusan']); ?></td>
                            <td class="text-truncate-mobile"><?php echo htmlspecialchars($x['namajurusan']); ?></td>
                            <td class="text-center">
                              <div class="btn-group" role="group" aria-label="Actions">
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-warning btn-sm btn-responsive" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEdit<?= $x['kodejurusan']; ?>"
                                        title="Edit">
                                  <i class="bi bi-pencil-square"></i>
                                  <span class="btn-text ms-1">Edit</span>
                                </button>
                                
                                <!-- Delete Button -->
                                <!-- <button type="button" class="btn btn-danger btn-sm btn-responsive" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalHapus<?= $x['kodejurusan']; ?>"
                                        title="Hapus">
                                  <i class="bi bi-trash"></i>
                                  <span class="btn-text ms-1">Hapus</span>
                                </button> -->
                              </div>
                            </td>
                          </tr>
                          
                          <!-- Edit Modal -->
                          <div class="modal fade" id="modalEdit<?= $x['kodejurusan']; ?>" 
                               data-bs-backdrop="static" 
                               data-bs-keyboard="false" 
                               tabindex="-1" 
                               aria-labelledby="labelEdit<?= $x['kodejurusan']; ?>" 
                               aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-responsive modal-dialog-centered">
                              <div class="modal-content">
                                <form action="" method="POST">
                                  <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title" id="labelEdit<?= $x['kodejurusan']; ?>">
                                      <i class="bi bi-pencil-square me-2"></i>Edit Data Jurusan
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  
                                  <div class="modal-body">
                                    <input type="hidden" name="kodejurusan" value="<?= $x['kodejurusan']; ?>">
                                    
                                    <div class="mb-3">
                                      <label for="kodejurusan_display<?= $x['kodejurusan']; ?>" class="form-label">Kode Jurusan</label>
                                      <input type="text" class="form-control" id="kodejurusan_display<?= $x['kodejurusan']; ?>" value="<?= $x['kodejurusan']; ?>" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                      <label for="namajurusan<?= $x['kodejurusan']; ?>" class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                                      <input type="text" class="form-control" id="namajurusan<?= $x['kodejurusan']; ?>" name="namajurusan" value="<?= htmlspecialchars($x['namajurusan']); ?>" required maxlength="100">
                                    </div>
                                  </div>
                                  
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                      <i class="bi bi-x-circle me-1"></i>Batal
                                    </button>
                                    <button type="submit" class="btn btn-warning" name="update_jurusan">
                                      <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                                    </button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          
                          <!-- Delete Modal -->
                          <!-- <div class="modal fade" id="modalHapus<?= $x['kodejurusan']; ?>" 
                               data-bs-backdrop="static" 
                               data-bs-keyboard="false" 
                               tabindex="-1" 
                               aria-labelledby="labelHapus<?= $x['kodejurusan']; ?>" 
                               aria-hidden="true">
                            <div class="modal-dialog modal-dialog-responsive modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                  <h5 class="modal-title" id="labelHapus<?= $x['kodejurusan']; ?>">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                                  </h5>
                                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <div class="modal-body text-center">
                                  <div class="mb-3">
                                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                                  </div>
                                  
                                  <h6 class="mb-3">Apakah Anda yakin ingin menghapus data ini?</h6>
                                  
                                  <div class="alert alert-light">
                                    <div class="row">
                                      <div class="col-sm-4"><strong>Kode Jurusan:</strong></div>
                                      <div class="col-sm-8"><?= htmlspecialchars($x['kodejurusan']); ?></div>
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-4"><strong>Nama Jurusan:</strong></div>
                                      <div class="col-sm-8"><?= htmlspecialchars($x['namajurusan']); ?></div>
                                    </div>
                                  </div>
                                  
                                  <p class="text-muted small mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Data yang sudah dihapus tidak dapat dikembalikan!
                                  </p>
                                </div>
                                
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i>Batal
                                  </button>
                                  <a href="hapus_data.php?kodejurusan=<?= urlencode($x['kodejurusan']); ?>" class="btn btn-danger">
                                    <i class="bi bi-trash me-1"></i>Ya, Hapus Data
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div> -->
                          <?php } ?>
                        </tbody>
                      </table>
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
        <div class="float-end d-none d-sm-inline">Sistem Informasi Jurusan</div>
        <strong>
          Copyright &copy; 2024&nbsp;
          <a href="#" class="text-decoration-none">Admin Panel</a>.
        </strong>
        All rights reserved.
      </footer>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="../dist/js/adminlte.js"></script>
    
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
    </script>
  </body>
</html>