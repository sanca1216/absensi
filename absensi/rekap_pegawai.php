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
        <title>Rekap Kehadiran Seluruh Pegawai</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    </head>
    <body style="background:#586df5;">
        <div class="container">
            <br/>
            <span style="color:#fff;">Selamat Datang, <?php echo $sesi['nama_pengguna'];?> (Admin)</span>
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
                    <table class="table table-hover table-bordered" id="mytable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Role</th>
                                <th>Total Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                $daftar = $proses->tampil_data('tbl_user');
                                foreach($daftar as $peg){
                                    $total = $proses->tampil_data_query("SELECT COUNT(*) as total FROM tbl_presensi WHERE id_login=?", [$peg['id_login']]);
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $peg['nama_pengguna'];?></td>
                                <td><?php echo ucfirst($peg['role']);?></td>
                                <td><?php echo $total['total'];?> hari</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            $('#mytable').dataTable();
        </script>
    </body>
</html>
