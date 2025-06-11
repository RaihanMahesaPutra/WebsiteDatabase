    <?php
    include 'koneksi.php';
    $db = new Database();

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
        header('location: data_siswa.php'); 
    }   
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tambah Data Siswa</title>
        <style>
            * {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                background: #f4f7f8;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .container {
                width: 40%;
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            }
            h2 {
                text-align: center;
                color: #003366;
                margin-bottom: 20px;
            }
            label {
                font-weight: bold;
                display: block;
                margin-top: 10px;
            }
            input, select {
                width: 100%;
                padding: 10px;
                margin-top: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 16px;
            }
            .radio-group {
                display: flex;
                gap: 20px;
                margin-top: 5px;
            }
            .radio-group input {
                width: auto;
            }
            input[type="submit"] {
                width: 100%;
                background: #007bff;
                color: white;
                padding: 12px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: 0.3s;
                font-size: 16px;
                margin-top: 20px;
            }
            input[type="submit"]:hover {
                background: #0056b3;
            }
        </style>
    </head>
    <body>  
    <div class="container">
        <h2>Tambah Data Siswa</h2>
        <form action="" method="post">
            <label for="nisn">NISN</label>
            <input type="text" id="nisn" name="nisn" required>

            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" required>
        
            <label>Jenis Kelamin</label>
            <div class="radio-group">
                <input type="radio" id="laki-laki" name="jeniskelamin" value="L" required>
                <label for="laki-laki">Laki-laki</label>

                <input type="radio" id="perempuan" name="jeniskelamin" value="P" required>
                <label for="perempuan">Perempuan</label>
            </div>
            
            <label for="kodejurusan">Jurusan</label>
            <select id="kodejurusan" name="kodejurusan" required>
                <option value="" disabled selected>Pilih Jurusan</option>
                <?php foreach ($jurusan as $j) : ?>
                    <option value="<?= $j['kodejurusan']; ?>"><?= $j['namajurusan']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="kelas">Kelas</label>
            <input type="text" id="kelas" name="kelas" required>

            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" required>
            
            <label for="agama">Agama</label>
            <select id="agama" name="agama" required>
                <option value="" disabled selected>Pilih Agama</option>
                <?php foreach ($agama as $a) : ?>
                    <option value="<?= $a['id_agama']; ?>"><?= $a['nama_agama']; ?></option>
                <?php endforeach; ?>
            </select>
            
            <label for="nohp">No HP</label>
            <input type="text" id="nohp" name="nohp" required>

            <input type="submit" name="Simpan" value="Submit">
        </form>
    </div>
    </body>
    </html>
