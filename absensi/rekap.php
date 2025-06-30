<?php
if(!empty($_SESSION)){ }else{ session_start(); }
require 'proses/panggil.php';

if(empty($sesi) || $sesi['role'] != 'admin'){ header('location:index.php'); }
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Rekap Kehadiran Pegawai</title>
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
            <h4 class="card-title">Rekap Kehadiran Seluruh Pegawai</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Total Hadir</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $query = "SELECT tbl_user.nama_pengguna, COUNT(tbl_presensi.id_presensi) AS total_hadir 
                          FROM tbl_user
                          LEFT JOIN tbl_presensi ON tbl_user.id_login = tbl_presensi.id_login
                          GROUP BY tbl_user.id_login
                          ORDER BY total_hadir DESC";
                $hasil = $proses->tampil_data_query_all($query);
                foreach($hasil as $row){
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['nama_pengguna']; ?></td>
                        <td><?php echo $row['total_hadir']; ?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
