<?php
include 'koneksi.php';
$db = new Database();
if (isset($_POST['Simpan'])) {
    $db->tambah_data_jurusan(
        $_POST['kodejurusan'],
        $_POST['namajurusan']
    );
    header('location: data_jurusan.php');
}  
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jurusan</title>
    <style>
        * {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #f4f7f8;
            text-align: center;
            padding: 20px;
        }
        .container {
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #003366;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    
<div class="container">
    <h2>Tambah Data Jurusan</h2>
    <form action="" method="post">
        <label for="kodejurusan">Kode Jurusan</label><br>
        <input type="text" id="kodejurusan" name="kodejurusan" required><br><br>

        <label for="namajurusan">Nama Jurusan</label><br>
        <input type="text" id="namajurusan" name="namajurusan" required><br><br>

        <input type="submit" name="Simpan" value="Tambah">
    </form>
</div>
</body>
</html>
