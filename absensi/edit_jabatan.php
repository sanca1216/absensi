<?php
    if(!empty($_SESSION)){ }else{ session_start(); }
    require 'proses/panggil.php';

    if($sesi['role'] != 'admin'){
        header('location:index.php');
    }

    $idGet = strip_tags($_GET['id']);
    $hasil = $proses->tampil_data_id('tbl_jabatan','id_jabatan',$idGet);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Edit Jabatan</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </head>
    <body style="background:#586df5;">
        <div class="container">
            <br/>
            <span style="color:#fff;">Selamat Datang, <?php echo $sesi['nama_pengguna'];?> (Admin)</span>
            <div class="float-right">    
                <a href="jabatan.php" class="btn btn-success btn-md" style="margin-right:1pc;"><span class="fa fa-home"></span> Kembali</a> 
                <a href="logout.php" class="btn btn-danger btn-md"><span class="fa fa-sign-out"></span> Logout</a>
            </div>        
            <br/><br/><br/>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Jabatan - <?php echo $hasil['nama_jabatan'];?></h4>
                        </div>
                        <div class="card-body">
                            <form action="proses/crud.php?aksi=edit_jabatan" method="POST">
                                <div class="form-group">
                                    <label>Nama Jabatan</label>
                                    <input type="text" value="<?php echo $hasil['nama_jabatan'];?>" class="form-control" name="nama_jabatan" required>
                                    <input type="hidden" name="id_jabatan" value="<?php echo $hasil['id_jabatan'];?>">
                                </div>
                                <button class="btn btn-primary btn-md" name="edit"><i class="fa fa-edit"> </i> Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </body>
</html>
