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
        <title>Data Jabatan</title>
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
            <h4 style="color:white;">Data Jabatan</h4>
            <button class="btn btn-success btn-md mb-3" data-toggle="modal" data-target="#tambahModal"><span class="fa fa-plus"></span> Tambah Jabatan</button>
            <div class="card">
                <div class="card-header"><h5>Daftar Jabatan</h5></div>
                <div class="card-body">
                    <table class="table table-hover table-bordered" id="mytable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jabatan</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                $hasil = $proses->tampil_data('tbl_jabatan');
                                foreach($hasil as $isi){
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $isi['nama_jabatan']?></td>
                                <td style="text-align: center;">
                                    <a href="edit_jabatan.php?id=<?php echo $isi['id_jabatan'];?>" class="btn btn-success btn-sm">
                                    <span class="fa fa-edit"></span></a>
                                    <a onclick="return confirm('Yakin ingin menghapus?')" href="proses/crud.php?aksi=hapus_jabatan&hapusid=<?php echo $isi['id_jabatan'];?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
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

        <!-- Modal Tambah Jabatan -->
        <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="proses/crud.php?aksi=tambah_jabatan" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Jabatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jabatan</label>
                        <input type="text" name="nama_jabatan" class="form-control" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
              </form>
            </div>
          </div>
        </div>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script> $('#mytable').dataTable(); </script>
    </body>
</html>
