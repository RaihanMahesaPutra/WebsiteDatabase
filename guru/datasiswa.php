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

// Proses form edit jika ada POST request
if ($_POST && isset($_POST['nisn'])) {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $jurusan = $_POST['jurusan'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $agama = $_POST['agama'];
    $nohp = $_POST['nohp'];
    
    // Update data siswa
    $db->update_data_siswa($nisn, $nama, $jeniskelamin, $kelas, $alamat, $nohp, $jurusan, $agama);
    
    // Redirect untuk menghindari double submit
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE 4 | Data Siswa Responsif</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Data Siswa Responsif" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../dist/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
    
    <!-- Custom CSS untuk responsif -->
    <style>
      /* Responsif untuk layar kecil */
      @media (max-width: 768px) {
        .table-responsive-stack tr {
          border: 1px solid #ccc;
          margin-bottom: 10px;
          display: block;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table-responsive-stack th,
        .table-responsive-stack td {
          border: none;
          display: block;
          text-align: left;
          padding: 8px 15px;
        }
        
        .table-responsive-stack th {
          display: none;
        }
        
        .table-responsive-stack td {
          border-bottom: 1px solid #eee;
          position: relative;
          padding-left: 50% !important;
        }
        
        .table-responsive-stack td:before {
          content: attr(data-label);
          position: absolute;
          left: 15px;
          width: 45%;
          padding-right: 10px;
          white-space: nowrap;
          font-weight: 600;
          color: #333;
        }
        
        .table-responsive-stack td:last-child {
          border-bottom: none;
        }
        
        /* Styling untuk tombol di mobile */
        .btn-group-mobile {
          display: flex;
          gap: 5px;
          flex-wrap: wrap;
        }
        
        .btn-group-mobile .btn {
          flex: 1;
          min-width: 70px;
        }
      }
      
      /* Styling untuk card di mobile */
      @media (max-width: 768px) {
        .student-card {
          background: #fff;
          border: 1px solid #ddd;
          border-radius: 8px;
          margin-bottom: 15px;
          padding: 15px;
          box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .student-card .card-header {
          background: #f8f9fa;
          padding: 10px 15px;
          margin: -15px -15px 15px -15px;
          border-radius: 7px 7px 0 0;
          border-bottom: 1px solid #ddd;
        }
        
        .student-info {
          margin-bottom: 10px;
        }
        
        .student-info strong {
          display: inline-block;
          width: 120px;
          color: #495057;
        }
        
        .student-actions {
          margin-top: 15px;
          padding-top: 15px;
          border-top: 1px solid #eee;
        }
      }
      
      /* Hide table pada mobile, show card */
      @media (max-width: 768px) {
        .table-view {
          display: none;
        }
        .card-view {
          display: block;
        }
      }
      
      /* Hide card pada desktop, show table */
      @media (min-width: 769px) {
        .table-view {
          display: block;
        }
        .card-view {
          display: none;
        }
      }
      
      /* Header responsif */
      @media (max-width: 576px) {
        .card-header h3 {
          font-size: 1.2rem;
          margin-bottom: 10px;
        }
        
        .card-header .btn {
          width: 100%;
          margin-top: 10px;
        }
        
        .card-header {
          text-align: center;
        }
      }

      .no-results {
          text-align: center;
          padding: 40px 20px;
          color: #6c757d;
      }

      .no-results i {
          font-size: 3rem;
          margin-bottom: 15px;
          opacity: 0.5;
      }

      .highlight {
          background-color: #fff3cd;
          padding: 2px 4px;
          border-radius: 3px;
          font-weight: 600;
      }

      .search-stats {
          font-size: 0.9rem;
          color: #6c757d;
          margin-top: 10px;
      }

      #clearSearch {
          text-decoration: none;
          color: #dc3545;
      }

      #clearSearch:hover {
          color: #c82333;
          text-decoration: underline;
      }

      .bg-pink {
        background-color: #e91e63 !important;
        color: white !important;
      }

      .bg-blue {
        background-color: #2196f3 !important; 
        color: white !important;
      }

      /* Atau gunakan warna yang lebih soft */
      .bg-pink-soft {
        background-color: #f8d7da !important;
        color: #721c24 !important;
      }

      .bg-blue-soft {
        background-color: #cce7ff !important;
        color: #004085 !important;
      }
    </style>
  </head>
  <!--end::Head-->
  <!--begin::Body-->
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
      <!--end::Header-->
      <?php include "Sidebar.php"; ?>
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <div class="card-header">
              <h3>Data Siswa</h3>
              <a href="tambahsiswa.php" class="btn btn-primary float-end">
                <i class="bi bi-plus-circle me-1"></i>Tambah Data
              </a>
            </div>
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Tabel Siswa</h3>
                  </div>
                  <!-- Search Container -->
                  <div class="card-body pb-0">
                    <div class="search-container">
                      <div class="row align-items-center">
                        <div class="col-md-8">
                          <div class="search-box">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" 
                                   id="searchInput" 
                                   class="form-control" 
                                   placeholder="Cari berdasarkan NISN, Nama, Kelas, Jurusan, atau Alamat..."
                                   autocomplete="off">
                          </div>
                        </div>
                        <div class="col-md-4 mt-2 mt-md-0">
                          <select id="filterJurusan" class="form-select">
                            <option value="">Semua Jurusan</option>
                            <?php foreach ($db->tampil_data_jurusan() as $jur) : ?>
                              <option value="<?= htmlspecialchars($jur['namajurusan']); ?>">
                                <?= htmlspecialchars($jur['namajurusan']); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="search-stats mt-2">
                        <span id="searchResults"></span>
                        <button id="clearSearch" class="btn btn-link btn-sm p-0 ms-2" style="display: none;">
                          <i class="bi bi-x-circle"></i> Hapus Filter
                        </button>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  
                  <!-- Table View untuk Desktop -->
                  <div class="card-body p-0 table-view">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover">
                        <thead class="table-dark">
                          <tr>
                              <th>NO</th>
                              <th>NISN</th>
                              <th>Nama</th>
                              <th>JK</th>
                              <th>Jurusan</th>
                              <th>Kelas</th>
                              <th>Alamat</th>
                              <th>Agama</th>
                              <th>NO HP</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          foreach ($db->tampil_data_siswa() as $x) {
                          ?>
                              <tr>
                                  <td><?= $no++; ?></td>
                                  <td><?= htmlspecialchars($x['nisn']); ?></td>
                                  <td><?= htmlspecialchars($x['nama']); ?></td>
                                  <td>
                                    <span class="badge <?= ($x['jeniskelamin'] == 'P') ? 'text-bg-danger' : 'text-bg-primary' ?>">
                                      <?php if($x['jeniskelamin'] == 'P'): ?>
                                        <i class="bi bi-gender-female me-1"></i>P
                                      <?php else: ?>
                                        <i class="bi bi-gender-male me-1"></i>L
                                      <?php endif; ?>
                                    </span>
                                  </td>
                                  <td><?= htmlspecialchars($x['namajurusan'] ?? '-'); ?></td>
                                  <td><?= htmlspecialchars($x['kelas']); ?></td>
                                  <td class="text-truncate" style="max-width: 150px;"><?= htmlspecialchars($x['alamat']); ?></td>
                                  <td><?= htmlspecialchars($x['nama_agama'] ?? '-'); ?></td>
                                  <td><?= htmlspecialchars($x['nohp']); ?></td>
                              </tr>
                          <?php
                          } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  
                  <!-- Card View untuk Mobile -->
                  <div class="card-body card-view">
                    <?php
                    $no = 1;
                    foreach ($db->tampil_data_siswa() as $x) {
                    ?>
                    <div class="student-card">
                      <div class="card-header">
                        <h6 class="mb-0">
                          <i class="bi bi-person-circle me-2"></i>
                          <?= htmlspecialchars($x['nama']); ?>
                          <span class="badge <?= ($x['jeniskelamin'] == 'P') ? 'bg-pink' : 'bg-primary' ?> float-end">
                            <?= ($x['jeniskelamin'] == 'P') ? 'Perempuan' : 'Laki-laki'; ?>
                          </span>
                        </h6>
                      </div>
                      
                      <div class="student-info">
                        <strong>NISN:</strong> <?= htmlspecialchars($x['nisn']); ?>
                      </div>
                      <div class="student-info">
                        <strong>Jurusan:</strong> <?= htmlspecialchars($x['namajurusan'] ?? '-'); ?>
                      </div>
                      <div class="student-info">
                        <strong>Kelas:</strong> <?= htmlspecialchars($x['kelas']); ?>
                      </div>
                      <div class="student-info">
                        <strong>Alamat:</strong> <?= htmlspecialchars($x['alamat']); ?>
                      </div>
                      <div class="student-info">
                        <strong>Agama:</strong> <?= htmlspecialchars($x['nama_agama'] ?? '-'); ?>
                      </div>
                      <div class="student-info">
                        <strong>No HP:</strong> <?= htmlspecialchars($x['nohp']); ?>
                      </div>
                    
                    </div>
                    <?php
                    } ?>
                  </div>
                  
                  <!-- Modal Edit (sama untuk desktop dan mobile) -->
                  
                  
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>  
        <!--end::App Content-->
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
    <script src="../dist/js/adminlte.js"></script>
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
      
      // Fungsi pencarian dan filter data siswa
      document.addEventListener('DOMContentLoaded', function() {
          const searchInput = document.getElementById('searchInput');
          const filterJurusan = document.getElementById('filterJurusan');
          const clearSearchBtn = document.getElementById('clearSearch');
          const searchResults = document.getElementById('searchResults');
          
          // Get all table rows (desktop view)
          const tableRows = document.querySelectorAll('.table-view tbody tr');
          // Get all student cards (mobile view)
          const studentCards = document.querySelectorAll('.card-view .student-card');
          
          let totalData = tableRows.length;
          let filteredCount = totalData;
          
          // Update search results counter
          function updateSearchResults(found, total, hasFilter = false) {
              if (hasFilter) {
                  searchResults.textContent = `Menampilkan ${found} dari ${total} data siswa`;
                  clearSearchBtn.style.display = 'inline-block';
              } else {
                  searchResults.textContent = `Total ${total} data siswa`;
                  clearSearchBtn.style.display = 'none';
              }
          }
          
          // Highlight search terms
          function highlightText(text, searchTerm) {
              if (!searchTerm.trim()) return text;
              
              const regex = new RegExp(`(${searchTerm.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&')})`, 'gi');
              return text.replace(regex, '<span class="highlight">$1</span>');
          }
          
          // Remove highlights
          function removeHighlights(element) {
              const highlights = element.querySelectorAll('.highlight');
              highlights.forEach(highlight => {
                  highlight.outerHTML = highlight.innerHTML;
              });
          }
          
          // Main search and filter function
          function searchAndFilter() {
              const searchTerm = searchInput.value.toLowerCase().trim();
              const selectedJurusan = filterJurusan.value.toLowerCase().trim();
              
              let visibleCount = 0;
              const hasFilter = searchTerm !== '' || selectedJurusan !== '';
              
              // Filter table rows (desktop view)
              tableRows.forEach(row => {
                  // Remove existing highlights
                  removeHighlights(row);
                  
                  // Get row data
                  const cells = row.querySelectorAll('td');
                  if (cells.length === 0) return; // Skip if no cells (header row)
                  
                  const nisn = cells[1].textContent.toLowerCase();
                  const nama = cells[2].textContent.toLowerCase();
                  const jurusan = cells[4].textContent.toLowerCase();
                  const kelas = cells[5].textContent.toLowerCase();
                  const alamat = cells[6].textContent.toLowerCase();
                  
                  // Check if matches search term
                  const matchesSearch = !searchTerm || 
                      nisn.includes(searchTerm) ||
                      nama.includes(searchTerm) ||
                      jurusan.includes(searchTerm) ||
                      kelas.includes(searchTerm) ||
                      alamat.includes(searchTerm);
                  
                  // Check if matches jurusan filter
                  const matchesJurusan = !selectedJurusan || jurusan.includes(selectedJurusan);
                  
                  // Show/hide row
                  if (matchesSearch && matchesJurusan) {
                      row.style.display = '';
                      visibleCount++;
                      
                      // Highlight search terms if exists
                      if (searchTerm) {
                          cells[1].innerHTML = highlightText(cells[1].textContent, searchTerm); // NISN
                          cells[2].innerHTML = highlightText(cells[2].textContent, searchTerm); // Nama
                          cells[4].innerHTML = highlightText(cells[4].textContent, searchTerm); // Jurusan
                          cells[5].innerHTML = highlightText(cells[5].textContent, searchTerm); // Kelas
                          cells[6].innerHTML = highlightText(cells[6].textContent, searchTerm); // Alamat
                      }
                  } else {
                      row.style.display = 'none';
                  }
              });
              
              // Filter student cards (mobile view)
              let visibleCardsCount = 0;
              studentCards.forEach(card => {
                  // Remove existing highlights
                  removeHighlights(card);
                  
                  // Get card data
                  const cardText = card.textContent.toLowerCase();
                  const studentInfos = card.querySelectorAll('.student-info');
                  
                  let nisn = '', nama = '', jurusan = '', kelas = '', alamat = '';
                  
                  // Extract data from student info
                  studentInfos.forEach(info => {
                      const text = info.textContent.toLowerCase();
                      if (text.includes('nisn:')) nisn = text.replace('nisn:', '').trim();
                      else if (text.includes('jurusan:')) jurusan = text.replace('jurusan:', '').trim();
                      else if (text.includes('kelas:')) kelas = text.replace('kelas:', '').trim();
                      else if (text.includes('alamat:')) alamat = text.replace('alamat:', '').trim();
                  });
                  
                  // Get nama from header
                  const nameElement = card.querySelector('.card-header h6');
                  if (nameElement) {
                      nama = nameElement.textContent.toLowerCase().replace(/perempuan|laki-laki/g, '').trim();
                  }
                  
                  // Check if matches search term
                  const matchesSearch = !searchTerm || 
                      nisn.includes(searchTerm) ||
                      nama.includes(searchTerm) ||
                      jurusan.includes(searchTerm) ||
                      kelas.includes(searchTerm) ||
                      alamat.includes(searchTerm);
                  
                  // Check if matches jurusan filter
                  const matchesJurusan = !selectedJurusan || jurusan.includes(selectedJurusan);
                  
                  // Show/hide card
                  if (matchesSearch && matchesJurusan) {
                      card.style.display = '';
                      visibleCardsCount++;
                      
                      // Highlight search terms if exists
                      if (searchTerm) {
                          studentInfos.forEach(info => {
                              info.innerHTML = highlightText(info.textContent, searchTerm);
                          });
                          if (nameElement) {
                              const badgeHtml = nameElement.querySelector('.badge') ? nameElement.querySelector('.badge').outerHTML : '';
                              const nameText = nameElement.textContent.replace(/Perempuan|Laki-laki/g, '').trim();
                              nameElement.innerHTML = `<i class="bi bi-person-circle me-2"></i>${highlightText(nameText, searchTerm)}${badgeHtml}`;
                          }
                      }
                  } else {
                      card.style.display = 'none';
                  }
              });
              
              // Update search results counter
              filteredCount = Math.max(visibleCount, visibleCardsCount);
              updateSearchResults(filteredCount, totalData, hasFilter);
              
              // Show "no results" message if no data found
              showNoResultsMessage(filteredCount === 0 && hasFilter);
          }
          
          // Show/hide no results message
          function showNoResultsMessage(show) {
              let noResultsDiv = document.querySelector('.no-results');
              
              if (show && !noResultsDiv) {
                  // Create no results message
                  noResultsDiv = document.createElement('div');
                  noResultsDiv.className = 'no-results';
                  noResultsDiv.innerHTML = `
                      <i class="bi bi-search"></i>
                      <h5>Tidak ada data yang ditemukan</h5>
                      <p>Coba ubah kata kunci pencarian atau filter yang digunakan</p>
                  `;
                  
                  // Add to both table and card views
                  const tableView = document.querySelector('.table-view .table-responsive');
                  const cardView = document.querySelector('.card-view');
                  
                  if (tableView) {
                      tableView.appendChild(noResultsDiv.cloneNode(true));
                  }
                  if (cardView) {
                      cardView.appendChild(noResultsDiv);
                  }
              } else if (!show && noResultsDiv) {
                  // Remove no results message
                  document.querySelectorAll('.no-results').forEach(el => el.remove());
              }
          }
          
          // Clear search and filters
          function clearSearch() {
              searchInput.value = '';
              filterJurusan.value = '';
              searchAndFilter();
              searchInput.focus();
          }
          
          // Event listeners
          searchInput.addEventListener('input', function() {
              // Debounce search for better performance
              clearTimeout(this.searchTimeout);
              this.searchTimeout = setTimeout(searchAndFilter, 300);
          });
          
          filterJurusan.addEventListener('change', searchAndFilter);
          clearSearchBtn.addEventListener('click', clearSearch);
          
          // Enter key search
          searchInput.addEventListener('keypress', function(e) {
              if (e.key === 'Enter') {
                  e.preventDefault();
                  clearTimeout(this.searchTimeout);
                  searchAndFilter();
              }
          });
          
          // Initialize search results counter
          updateSearchResults(totalData, totalData, false);
          
          // Focus on search input when page loads
          searchInput.focus();
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>