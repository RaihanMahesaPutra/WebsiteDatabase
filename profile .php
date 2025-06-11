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
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile - Admin Panel</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
/* Profile Avatar */
.profile-avatar .avatar-circle {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 2.5rem;
  box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

/* Profile Card */
.profile-card {
  border: none;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.profile-header {
  background: linear-gradient(135deg,rgb(88, 162, 236) 0%,rgb(119, 173, 226) 100%);
  border-bottom: 1px solid #dee2e6;
  padding: 1.5rem 1.5rem 1rem;
}

/* Profile Info */
.profile-info .info-row {
  display: flex;
  align-items: center;
  padding: 1rem 0;
  border-bottom: 1px solid #f1f3f4;
  transition: background-color 0.2s ease;
}

.profile-info .info-row:last-child {
  border-bottom: none;
}

.profile-info .info-row:hover {
  background-color: #f8f9fa;
  margin: 0 -1rem;
  padding-left: 1rem;
  padding-right: 1rem;
  border-radius: 8px;
}

.info-label {
  display: flex;
  align-items: center;
  min-width: 140px;
  font-weight: 600;
  color: #495057;
  font-size: 0.9rem;
}

.info-label i {
  margin-right: 8px;
  width: 16px;
  color: #6c757d;
}

.info-value {
  flex: 1;
  color: #212529;
  font-size: 0.95rem;
}

/* Status Badge */
.status-badge {
  display: inline-flex;
  align-items: center;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
}

.status-badge.active {
  background-color: #d4edda;
  color: #155724;
}

.status-badge i {
  font-size: 0.6rem;
  margin-right: 6px;
}

/* Profile Actions */
.profile-actions {
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid #e9ecef;
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.btn-edit {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  color: white;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn-edit:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
  color: white;
}

/* Stats Card */
.stats-card, .security-card {
  border: none;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.stats-card .card-header,
.security-card .card-header {
  background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
  color: white;
  border-bottom: none;
  border-radius: 16px 16px 0 0;
}

.stat-item {
  display: flex;
  align-items: center;
  padding: 1rem 0;
  border-bottom: 1px solid #f1f3f4;
}

.stat-item:last-child {
  border-bottom: none;
}

.stat-icon {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
  color: #1976d2;
}

.stat-content h6 {
  margin-bottom: 4px;
  font-weight: 600;
  color: #495057;
}

.stat-content p {
  margin-bottom: 0;
  font-size: 0.9rem;
}

/* Security Card */
.security-card .card-header {
  background: linear-gradient(135deg, #fd7e14 0%, #f8b739 100%);
}

.security-item {
  padding: 1rem 0;
  border-bottom: 1px solid #f1f3f4;
}

.security-item:last-child {
  border-bottom: none;
}

.security-item h6 {
  color: #495057;
  font-weight: 600;
}

/* Form Switches */
.form-switch .form-check-input {
  width: 2.5rem;
  height: 1.25rem;
}

.form-switch .form-check-input:checked {
  background-color: #28a745;
  border-color: #28a745;
}

/* Responsive */
@media (max-width: 768px) {
  .profile-avatar .avatar-circle {
    width: 60px;
    height: 60px;
    font-size: 2rem;
  }
  
  .info-label {
    min-width: 120px;
    font-size: 0.85rem;
  }
  
  .info-value {
    font-size: 0.9rem;
  }
  
  .profile-actions {
    flex-direction: column;
  }
  
  .btn-edit, .btn-secondary {
    width: 100%;
    justify-content: center;
  }
}

/* Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.profile-card, .stats-card, .security-card {
  animation: fadeInUp 0.6s ease-out;
}

.stats-card {
  animation-delay: 0.1s;
}

.security-card {
  animation-delay: 0.2s;
}
</style>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
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
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="dist/assets/img/user2-160x160.jpg"
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
      <!--end::Header-->
      <?php include "Sidebar.php"; ?>
      <!-- Content Wrapper -->
    <main class="app-main">
      <div class="app-content p-4">
        <div class="container-fluid">
          <!-- Profile Header -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="d-flex align-items-center">
                <div class="profile-avatar me-3">
                  <div class="avatar-circle">
                    <i class="bi bi-person-fill"></i>
                  </div>
                </div>
                <div>
                  <h2 class="mb-1 text-dark fw-bold"><?= htmlspecialchars($user['username']) ?></h2>
                  <p class="text-muted mb-0">
                    <i class="bi bi-shield-check me-1"></i>
                    Administrator
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Profile Content -->
          <div class="row">
            <!-- Main Profile Card -->
            <div class="col-lg-8 col-md-12 mb-4">
              <div class="card profile-card">
                <div class="card-header profile-header">
                  <h4 class="card-title mb-0">
                    <i class="bi bi-person-lines-fill me-2"></i>Informasi Profil
                  </h4>
                </div>
                <div class="card-body p-4">
                  <div class="profile-info">
                    <div class="info-row">
                      <div class="info-label">
                        <i class="bi bi-person-badge"></i>
                        <span>Username</span>
                      </div>
                      <div class="info-value">
                        <?= htmlspecialchars($user['username']) ?>
                      </div>
                    </div>
                    
                    <div class="info-row">
                      <div class="info-label">
                        <i class="bi bi-envelope"></i>
                        <span>Email</span>
                      </div>
                      <div class="info-value">
                        <?= !empty($user['email']) ? htmlspecialchars($user['email']) : '<span class="text-muted">Belum diisi</span>' ?>
                      </div>
                    </div>

                    <div class="info-row">
                      <div class="info-label">
                        <i class="bi bi-calendar3"></i>
                        <span>Bergabung</span>
                      </div>
                      <div class="info-value">
                        <?= isset($user['created_at']) ? date('d F Y', strtotime($user['created_at'])) : 'Tidak diketahui' ?>
                      </div>
                    </div>

                    <div class="info-row">
                      <div class="info-label">
                        <i class="bi bi-activity"></i>
                        <span>Level</span>
                      </div>
                      <div class="info-value">
                        <?= !empty($user['level']) ? htmlspecialchars($user['level']) : '<span class="text-muted">Belum diisi</span>' ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2014-2024&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
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
    
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Smooth hover effects for info rows
  const infoRows = document.querySelectorAll('.info-row');
  infoRows.forEach(row => {
    row.addEventListener('mouseenter', function() {
      this.style.transform = 'translateX(5px)';
    });
    
    row.addEventListener('mouseleave', function() {
      this.style.transform = 'translateX(0)';
    });
  });
  
  // Toggle switches functionality
  const switches = document.querySelectorAll('.form-check-input');
  switches.forEach(switchEl => {
    switchEl.addEventListener('change', function() {
      const label = this.closest('.security-item').querySelector('h6').textContent;
      const status = this.checked ? 'diaktifkan' : 'dinonaktifkan';
      
      // Simple notification (you can replace with a proper toast/notification system)
      setTimeout(() => {
        alert(`${label} telah ${status}`);
      }, 300);
    });
  });
  
  // Profile avatar click effect
  const avatar = document.querySelector('.avatar-circle');
  if (avatar) {
    avatar.addEventListener('click', function() {
      this.style.transform = 'scale(0.95)';
      setTimeout(() => {
        this.style.transform = 'scale(1)';
      }, 150);
    });
  }
});
</script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
  </body>

</html>
