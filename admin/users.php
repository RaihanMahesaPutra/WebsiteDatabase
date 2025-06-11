<?php
session_start();
include "koneksi.php";
$db = new database();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$user = $db->koneksi->query("SELECT * FROM users WHERE id = '$user_id'")->fetch_assoc();
if (isset($_GET['cari']) && $_GET['cari'] !== '') {
  $keyword = $db->koneksi->real_escape_string($_GET['cari']);
  $users = $db->koneksi->query("SELECT * FROM users WHERE username LIKE '%$keyword%' OR email LIKE '%$keyword%'");
} else {
  $users = $db->koneksi->query("SELECT * FROM users");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="../dist/css/adminlte.css" rel="stylesheet">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">

    <!-- Navbar -->
    <nav class="app-header navbar navbar-expand bg-body">
      <div class="container-fluid">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="bi bi-list"></i></a>
          </li>
          <li class="nav-item d-none d-md-block"><a href="index.php" class="nav-link">Home</a></li>
        </ul>
        <ul class="navbar-nav ms-auto">
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
        </ul>
      </div>
    </nav>

    <!-- Sidebar -->
    <?php include "Sidebar.php"; ?>

    <!-- Main Content -->
    <div class="content-wrapper p-4">
      <div class="container-fluid">
        <div class="card shadow-sm">
          <div class="card-body table-responsive">
            <?php if ($users->num_rows > 0): ?>
              <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; while ($row = $users->fetch_assoc()): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= htmlspecialchars($row['username']) ?></td>
                      <td><?= htmlspecialchars($row['email']) ?></td>
                      <td><?= htmlspecialchars($row['level']) ?></td>
                      <td>
                        <!-- Tombol Edit -->
                        <!--<button class="btn btn-warning btn-sm mb-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEdit<?= $row['id']; ?>">
                          <i class="bi bi-pencil-square"></i>
                        </button>

                        Modal Edit
                        <div class="modal fade" id="modalEdit<?= $row['id']; ?>" tabindex="-1" aria-labelledby="editLabel<?= $row['id']; ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form action="proses_edit_user.php" method="POST">
                                <div class="modal-header bg-warning">
                                  <h5 class="modal-title" id="editLabel<?= $row['id']; ?>">Edit User</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                  <div class="mb-3">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($row['username']); ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['email']); ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label>Password Baru (opsional)</label>
                                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div> -->

                        <!-- Tombol Hapus -->
                        <button class="btn btn-danger btn-sm mb-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalHapus<?= $row['id']; ?>">
                          <i class="bi bi-trash"></i>
                        </button>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modalHapus<?= $row['id']; ?>" tabindex="-1" aria-labelledby="hapusLabel<?= $row['id']; ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="hapusLabel<?= $row['id']; ?>">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                <p>Yakin ingin menghapus user <strong><?= htmlspecialchars($row['username']); ?></strong>?</p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <a href="hapus_user.php?id=<?= $row['id']; ?>" class="btn btn-danger">Hapus</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            <?php else: ?>
              <div class="alert alert-info text-center mb-0">Belum ada data user yang tersedia.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="app-footer mt-3">
      <div class="float-end d-none d-sm-inline">Sistem Informasi Sekolah</div>
      <strong>&copy; 2024 <a href="#">NamaSekolah</a>.</strong> All rights reserved.
    </footer>

  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../dist/js/adminlte.js"></script>
</body>
</html>
