<?php
    if(!empty($_SESSION)){ }else{ session_start(); }
    require 'proses/panggil.php';

    if(empty($sesi)){ header('location:login.php'); }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Presensi Kehadiran</title>
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
                    <h4 class="card-title">Presensi Kehadiran</h4>
                </div>
                <div class="card-body text-center">
                    <form action="proses/crud.php?aksi=presensi" method="POST">
                        <input type="hidden" name="id_login" value="<?php echo $sesi['id_login']; ?>">
                        <button type="submit" name="absen_masuk" class="btn btn-primary btn-lg m-2"><i class="fa fa-sign-in"></i> Check In</button>
                        <button type="submit" name="absen_pulang" class="btn btn-danger btn-lg m-2"><i class="fa fa-sign-out"></i> Check Out</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
