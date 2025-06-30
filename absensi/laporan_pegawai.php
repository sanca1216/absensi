<?php
    if(!empty($_SESSION)){ }else{ session_start(); }
    require 'proses/panggil.php';

    if($sesi['role'] != 'admin'){
        header('location:index.php');
    }

    $daftar_pegawai = $proses->tampil_data('tbl_user');
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Laporan Kehadiran Pegawai</title>
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
                    <h4 class="card-title">Laporan Kehadiran Pegawai</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="form-group">
                            <label>Pilih Pegawai</label>
                            <select name="id_login" class="form-control" required>
                                <option value="">-- Pilih Pegawai --</option>
                                <?php foreach($daftar_pegawai as $peg): ?>
                                    <option value="<?php echo $peg['id_login']; ?>" <?php if($_GET['id_login']==$peg['id_login']) echo 'selected'; ?>>
                                        <?php echo $peg['nama_pengguna']; ?> (<?php echo ucfirst($peg['role']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button class="btn btn-primary btn-md"><i class="fa fa-search"></i> Tampilkan Laporan</button>
                    </form>
                    <br/>
                    <?php if(!empty($_GET['id_login'])): ?>
                        <?php
                            $id_login = strip_tags($_GET['id_login']);
                            $riwayat = $proses->tampil_data_query_all("SELECT * FROM tbl_presensi WHERE id_login=? ORDER BY tgl_presensi DESC", [$id_login]);
                            $pegawai = $proses->tampil_data_id('tbl_user','id_login',$id_login);
                        ?>
                        <h5 style="color:white;">Laporan Kehadiran: <?php echo $pegawai['nama_pengguna']; ?> (<?php echo ucfirst($pegawai['role']); ?>)</h5>
                        <table class="table table-hover table-bordered" id="mytable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($riwayat as $absen): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $absen['tgl_presensi']; ?></td>
                                    <td><?php echo $absen['jam_masuk'] ?? '-'; ?></td>
                                    <td><?php echo $absen['jam_pulang'] ?? '-'; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script>
            $('#mytable').dataTable();
        </script>
    </body>
</html>
