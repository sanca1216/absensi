<?php
    if(!empty($_SESSION)){ }else{ session_start(); }
    require 'proses/panggil.php';

    // Cek apakah admin, kalau bukan redirect ke index
    if($sesi['role'] != 'admin'){
        header('location:index.php');
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Data Karyawan</title>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <h4 style="color:white;">Data Karyawan</h4>
            <a href="tambah.php" class="btn btn-success btn-md mb-3"><span class="fa fa-plus"></span> Tambah Karyawan</a>
            <div class="card">
                <div class="card-header"><h5>Daftar Karyawan</h5></div>
                <div class="card-body">
                    <table class="table table-hover table-bordered" id="mytable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Username</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                $hasil = $proses->tampil_data_query("SELECT * FROM tbl_user WHERE role='karyawan'");
                                foreach($hasil as $isi){
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $isi['nama_pengguna']?></td>
                                <td><?php echo $isi['telepon'];?></td>
                                <td><?php echo $isi['email'];?></td>
                                <td><?php echo $isi['alamat'];?></td>
                                <td><?php echo $isi['username'];?></td>
                                <td style="text-align: center;">
                                    <a href="edit.php?id=<?php echo $isi['id_login'];?>" class="btn btn-success btn-sm">
                                    <span class="fa fa-edit"></span></a>
                                    <a onclick="return confirm('Yakin ingin menghapus?')" href="proses/crud.php?aksi=hapus&hapusid=<?php echo $isi['id_login'];?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                            <?php
                                $no++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script> $('#mytable').dataTable(); </script>
    </body>
</html>
