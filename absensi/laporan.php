<?php
if(!empty($_SESSION)){ }else{ session_start(); }
require 'proses/panggil.php';

if(empty($sesi) || $sesi['role'] != 'admin'){ header('location:index.php'); }
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Laporan Kehadiran Per Pegawai</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body style="background:#586df5;">
<div class="container">
    <br/>
    <span style="color:#fff;">Selamat Datang, <?php echo $sesi['nama_pengguna'];?> (<?php echo ucfirst($sesi['role']); ?>)</span>
    <div class="float-right">    
        <a href="index.php" class="btn btn-success btn-md" style="margin-right:1pc;"><span class="fa fa-home"></span> Beranda</a> 
        <a href="logout.php" class="btn btn-danger btn-md"><span class="fa fa-sign-out"></span> Logout</a>
    </div>        
    <br/><br/>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Laporan Kehadiran Per Pegawai</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $query = "SELECT tbl_presensi.*, tbl_user.nama_pengguna FROM tbl_presensi
                          JOIN tbl_user ON tbl_presensi.id_login = tbl_user.id_login
                          ORDER BY tgl_presensi DESC, jam_masuk ASC";
                $hasil = $proses->tampil_data_query_all($query);
                foreach($hasil as $row){
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['nama_pengguna']; ?></td>
                        <td><?php echo $row['tgl_presensi']; ?></td>
                        <td><?php echo $row['jam_masuk']; ?></td>
                        <td><?php echo $row['jam_pulang'] ?: '-'; ?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
