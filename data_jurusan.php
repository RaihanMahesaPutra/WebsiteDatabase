<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jurusan</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
    <style>
        body {
            font-family: 'Poppins', Arial;
            background-color: #f4f4f4;
            text-align: center;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color:rgb(0, 0, 0);
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .tambah {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            background-color: #5bc0de;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .tambah:hover {
            background-color: #31b0d5;
        }   
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 14px;
        }
        .edit {
            background-color:#70ff00;
        }
        .hapus {
            background-color:#ffe400 ;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Data Jurusan</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Kode Jurusan</th>
            <th>Nama Jurusan</th>
        </tr>
        <?php
        include 'koneksi.php';
        $db = new Database();
        $jurusan = $db->tampil_data_jurusan();
        $no = 1;
        foreach ($jurusan as $data) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$data['kodejurusan']}</td>
                    <td>{$data['namajurusan']}</td>
                  </tr>";
            $no++;
        }
        ?>
    </table>

    <a href="tambah_jurusan.php" class="btn">+ Tambah Data Jurusan</a>
</div>
</body>
</html>