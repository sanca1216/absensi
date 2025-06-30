<?php
    if(!empty($_SESSION)){ }else{ session_start(); }
    require 'proses/panggil.php';

    if($sesi['role'] != 'admin'){
        header('location:index.php');
    }
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Beranda Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body style="background:#586df5;">
    <div class="container">
        <br/>
        <h2 style="color:#fff;">Selamat Datang, <?php echo $sesi['nama_pengguna'];?> (Admin)</h2>
        <div class="float-right">
            <a href="logout.php" class="btn btn-danger btn-md"><span class="fa fa-sign-out"></span> Logout</a>
        </div>
        <br/><br/>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Menu Utama Admin</h4>
            </div>
            <div class="card-body">
                <a href="data_karyawan.php" class="btn btn-primary btn-block">Data Karyawan</a>
                <a href="data_dosen.php" class="btn btn-primary btn-block">Data Dosen</a>
                <a href="data_security.php" class="btn btn-primary btn-block">Data Security</a>
                <a href="data_jabatan.php" class="btn btn-primary btn-block">Data Jabatan</a>
                <a href="presensi.php" class="btn btn-primary btn-block">Presensi</a>
                <a href="laporan_kehadiran.php" class="btn btn-primary btn-block">Laporan Kehadiran Per Pegawai</a>
                <a href="rekap_pegawai.php" class="btn btn-primary btn-block">Rekap Kehadiran Seluruh Pegawai</a>
            </div>
        </div>
    </div>
</body>
</html>
