<?php
class database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    
    private $port = 3307;
 
    private $database = "sekolah";
    public $koneksi;

    function __construct() {
        $this->koneksi = mysqli_connect($this->host, $this->user, $this->password, $this->database, $this->port);
    
        if (!$this->koneksi) {
            die("Koneksi ke database gagal: " . mysqli_connect_error());
        }
    }
    
    public function tampil_data_siswa() {
        $hasil = [];
        $query = "SELECT siswa.*, jurusan.namajurusan, agama.nama_agama
                  FROM siswa 
                  LEFT JOIN jurusan ON siswa.kodejurusan = jurusan.kodejurusan
                  LEFT JOIN agama ON siswa.agama = agama.id_agama";

        $data = $this->koneksi->query($query);

        if (!$data) {
            die("Error Query: " . $this->koneksi->error);
        }

        while ($row = $data->fetch_assoc()) {
            $hasil[] = $row;
        }

        return $hasil;
    }

    public function tampil_data_jurusan() {
        $hasil = array();
        $data = mysqli_query($this->koneksi, "SELECT * FROM jurusan");

        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $hasil[] = $row;
            }
        }

        return $hasil;
    }
    
    public function tampil_data_agama() {
        $hasil = array();
        $data = mysqli_query($this->koneksi, "SELECT * FROM agama");

        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $hasil[] = $row;
            }
        }

        return $hasil;
    }
    
    public function tambah_data_siswa($nisn, $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp) {
        $query = "INSERT INTO siswa (nisn, nama, jeniskelamin, kodejurusan, kelas, alamat, agama, nohp) 
                  VALUES ('$nisn', '$nama', '$jeniskelamin', '$kodejurusan', '$kelas', '$alamat', '$agama', '$nohp')";
        mysqli_query($this->koneksi, $query) or die(mysqli_error($this->koneksi));
    }
    
    public function tambah_data_jurusan($kodejurusan, $namajurusan): void {
        $query = "INSERT INTO jurusan (kodejurusan, namajurusan) VALUES ('$kodejurusan', '$namajurusan')";
        mysqli_query($this->koneksi, $query) or die(mysqli_error($this->koneksi));
    }
    
    public function tambah_data_agama($id_agama, $nama_agama) {
        $query = "INSERT INTO agama (id_agama, nama_agama) VALUES ('$id_agama','$nama_agama')";
        mysqli_query($this->koneksi, $query) or die(mysqli_error($this->koneksi));
    }

    // dataagama.php - Updated delete functionality
    public function hapus_data_agama($id_agama) {
        // Check if agama is being used by any siswa
        $check_query = "SELECT COUNT(*) as total FROM siswa WHERE agama = '$id_agama'";
        $result = $this->koneksi->query($check_query);
        $row = $result->fetch_assoc();
        
        if ($row['total'] > 0) {
            return false; // Return false if agama is in use
        }
        
        $query = "DELETE FROM agama WHERE id_agama='$id_agama'";
        return $this->koneksi->query($query);
    }

    // datajurusan.php - Updated delete functionality
    public function hapus_data_jurusan($kodejurusan) {
        // Check if jurusan is being used by any siswa
        $check_query = "SELECT COUNT(*) as total FROM siswa WHERE kodejurusan = '$kodejurusan'";
        $result = $this->koneksi->query($check_query);
        $row = $result->fetch_assoc();
        
        if ($row['total'] > 0) {
            return false; // Return false if jurusan is in use
        }
        
        $query = "DELETE FROM jurusan WHERE kodejurusan='$kodejurusan'";
        return $this->koneksi->query($query);
    }

    // datasiswa.php - Updated delete functionality
    public function hapus_data_siswa($nisn) {
        $query = "DELETE FROM siswa WHERE nisn='$nisn'";
        return $this->koneksi->query($query);
    }

    public function login_user($username, $password) {
    $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->koneksi->query($query);
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }
    public function update_data_siswa($nisn, $nama, $jeniskelamin, $kelas, $alamat, $nohp, $jurusan, $agama) {
        $query = "UPDATE siswa SET 
                  nama='$nama', 
                  jeniskelamin='$jeniskelamin', 
                  kelas='$kelas', 
                  alamat='$alamat', 
                  nohp='$nohp',
                  kodejurusan='$jurusan',
                  agama='$agama'
                  WHERE nisn='$nisn'";
        mysqli_query($this->koneksi, $query);
        if (mysqli_affected_rows($this->koneksi) > 0) {
            return true; // Update successful
        } else {
            return false; // Update failed
        }       
    }
}
?>