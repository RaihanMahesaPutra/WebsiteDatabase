<?php
include "koneksi.php";
$db = new database();


if (isset($_GET['idsiswa'])) {
    $idsiswa = $_GET['idsiswa'];
    $query = "DELETE FROM siswa WHERE idsiswa = '$idsiswa'";
    $result = mysqli_query($db->koneksi, $query);

    if ($result) {
        echo "<script>
                alert('Data siswa berhasil dihapus!');
                window.location.href='datasiswa.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data siswa!');
                window.location.href='datasiswa.php';
              </script>";
    }
}


elseif (isset($_GET['kodejurusan'])) {
    $kodejurusan = $_GET['kodejurusan']; // ini yang benar
    $query = "DELETE FROM jurusan WHERE kodejurusan = '$kodejurusan'";
    $result = mysqli_query($db->koneksi, $query);

    if ($result) {
        echo "<script>
                alert('Data jurusan berhasil dihapus!');
                window.location.href='datajurusan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data jurusan!');
                window.location.href='datajurusan.php';
              </script>";
    }
}



elseif (isset($_GET['id_agama'])) {
    $id_agama = $_GET['id_agama'];
    $query = "DELETE FROM agama WHERE id_agama = '$id_agama'";
    $result = mysqli_query($db->koneksi, $query);

    if ($result) {
        echo "<script>
                alert('Data agama berhasil dihapus!');
                window.location.href='dataagama.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data agama!');
                window.location.href='dataagama.php';
              </script>";
    }
}

else {
    echo "<script>
            alert('Data tidak ditemukan!');
            window.location.href='index.php';
          </script>";
}
?>
