<?php
include "koneksi.php";
$db = new database();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            text-align: center;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color:rgb(0, 0, 0);
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }   
        a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
        }
        a:hover {
            opacity: 0.8;
        }
        .edit {
            background-color:#70ff00;
            color: white;
        }
        .hapus {
            background-color:#0026ff;
            color: white;
        }
        .tambah {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Data Siswa</h2>
    <table>
        <tr>
            <th>NO</th>
            <th>NISN</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Alamat</th>
            <th>Agama</th>
            <th>NO HP</th>
            <th>Option</th>
        </tr>
        <?php
        $no = 1;
        foreach ($db->tampil_data_siswa() as $x) {
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($x['nisn']); ?></td>
                <td><?= htmlspecialchars($x['nama']); ?></td>
                <td><?= ($x['jeniskelamin'] == 'P') ? 'Perempuan' : 'Laki-laki'; ?></td>
                <td><?= htmlspecialchars($x['namajurusan'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($x['kelas']); ?></td>
                <td><?= htmlspecialchars($x['alamat']); ?></td>
                <td><?= htmlspecialchars($x['nama_agama'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($x['nohp']); ?></td>
                <td>
                    <a href="edit_siswa.php?id=<?= $x['nisn']; ?>&aksi=edit" class="btn edit">Edit</a>
                    <a href="proses.php?id=<?= $x['nisn']; ?>&aksi=hapus" class="btn hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php
            } ?>
    </table>
    <a href="tambah_siswa.php" class="btn tambah">+ Tambah Data Siswa</a>
    </body>
</html>