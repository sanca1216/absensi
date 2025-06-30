<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'panggil.php';
?>

<?php
    require 'panggil.php';

    // proses tambah
    if(!empty($_GET['aksi'] == 'tambah'))
    {
        $nama = strip_tags($_POST['nama']);
        $telepon = strip_tags($_POST['telepon']);
        $email = strip_tags($_POST['email']);
        $alamat = strip_tags($_POST['alamat']);
        $user = strip_tags($_POST['user']);
        $pass = strip_tags($_POST['pass']);
        
        $tabel = 'tbl_user';
        # proses insert
        $data[] = array(
            'username'		=>$user,
            'password'		=>md5($pass),
            'nama_pengguna'	=>$nama,
            'telepon'		=>$telepon,
            'email'			=>$email,
            'alamat'		=>$alamat,
            'role'          =>$role
        );
        $proses->tambah_data($tabel,$data);
        echo '<script>alert("Tambah Data Berhasil");window.location="../index.php"</script>';
    }

    // proses edit
	if(!empty($_GET['aksi'] == 'edit'))
	{
		$nama = strip_tags($_POST['nama']);
		$telepon = strip_tags($_POST['telepon']);
		$email = strip_tags($_POST['email']);
		$alamat = strip_tags($_POST['alamat']);
		$user = strip_tags($_POST['user']);
		$pass = strip_tags($_POST['pass']);
		
        // jika password tidak diisi
        if($pass == '')
        {
            $data = array(
                'username'		=>$user,
                'nama_pengguna'	=>$nama,
                'telepon'		=>$telepon,
                'email'			=>$email,
                'alamat'		=>$alamat
            );
        }else{

            $data = array(
                'username'		=>$user,
                'password'		=>md5($pass),
                'nama_pengguna'	=>$nama,
                'telepon'		=>$telepon,
                'email'			=>$email,
                'alamat'		=>$alamat,
                'role'          =>$role
            );
        }
        $tabel = 'tbl_user';
        $where = 'id_login';
        $id = strip_tags($_POST['id_login']);
        $proses->edit_data($tabel,$data,$where,$id);
        echo '<script>alert("Edit Data Berhasil");window.location="../index.php"</script>';
    }
    
    // hapus data
    if(!empty($_GET['aksi'] == 'hapus'))
    {
        $tabel = 'tbl_user';
        $where = 'id_login';
        $id = strip_tags($_GET['hapusid']);
        $proses->hapus_data($tabel,$where,$id);
        echo '<script>alert("Hapus Data Berhasil");window.location="../index.php"</script>';
    }

    // login
    if (!empty($_GET['aksi']) && $_GET['aksi'] == 'login') {   
    // validasi text untuk filter karakter khusus dengan fungsi strip_tags()
    $user = strip_tags($_POST['user']);
    $pass = strip_tags($_POST['pass']);

    // panggil fungsi proses_login() yang ada di class prosesCrud()
    $result = $proses->proses_login($user, $pass);
    if ($result == 'gagal') {
        echo "<script>alert('Login gagal! Username atau password salah.');window.location='../login.php';</script>";
    } else {
        $_SESSION['ADMIN'] = $result;

        // Arahkan berdasarkan role
        if ($result['role'] == 'admin') {
            echo "<script>window.location='../beranda_admin.php';</script>";
        } elseif ($result['role'] == 'karyawan' || $result['role'] == 'dosen' || $result['role'] == 'security') {
            echo "<script>window.location='../presensi.php';</script>";
        } else {
            echo "<script>alert('Role tidak dikenali!');window.location='../login.php';</script>";
        }
    }
}


        // Tambah Jabatan
    if(!empty($_GET['aksi'] == 'tambah_jabatan'))
    {
        $nama_jabatan = strip_tags($_POST['nama_jabatan']);
        $data[] = array('nama_jabatan' => $nama_jabatan);
        $proses->tambah_data('tbl_jabatan',$data);
        echo '<script>alert("Tambah Jabatan Berhasil");window.location="../jabatan.php"</script>';
    }

    // Hapus Jabatan
    if(!empty($_GET['aksi'] == 'hapus_jabatan'))
    {
        $proses->hapus_data('tbl_jabatan','id_jabatan',strip_tags($_GET['hapusid']));
        echo '<script>alert("Hapus Jabatan Berhasil");window.location="../jabatan.php"</script>';
    }

        // Edit Jabatan
    if(!empty($_GET['aksi'] == 'edit_jabatan'))
    {
        $nama_jabatan = strip_tags($_POST['nama_jabatan']);
        $id = strip_tags($_POST['id_jabatan']);
        $data = array('nama_jabatan' => $nama_jabatan);
        $proses->edit_data('tbl_jabatan',$data,'id_jabatan',$id);
        echo '<script>alert("Edit Jabatan Berhasil");window.location="../jabatan.php"</script>';
    }

        // Presensi
if (!empty($_GET['aksi']) && $_GET['aksi'] == 'presensi') {
    $id_login = strip_tags($_POST['id_login']);
    $tgl = date('Y-m-d');
    $waktu = date('H:i:s');

    if (isset($_POST['absen_masuk'])) {
        // Check apakah sudah absen masuk hari ini
        $cek = $proses->tampil_data_query("SELECT * FROM tbl_presensi WHERE id_login=? AND tgl_presensi=?", [$id_login, $tgl]);
        if (empty($cek)) {
            $data[] = array(
                'id_login' => $id_login,
                'tgl_presensi' => $tgl,
                'jam_masuk' => $waktu
            );
            $proses->tambah_data('tbl_presensi', $data);
            echo '<script>alert("Check In berhasil!");window.location="../presensi.php"</script>';
        } else {
            echo '<script>alert("Anda sudah Check In hari ini.");window.location="../presensi.php"</script>';
        }
    }

    if (isset($_POST['absen_pulang'])) {
        $data = array('jam_pulang' => $waktu);
        $proses->edit_data_presensi('tbl_presensi', $data, $id_login, $tgl);
        echo '<script>alert("Check Out berhasil!");window.location="../presensi.php"</script>';
    }
}


    if(isset($_POST['absen_pulang'])){
    // cek sudah check in belum
    $cek = $proses->tampil_data_query("SELECT * FROM tbl_presensi WHERE id_login=? AND tgl_presensi=?", [$id_login, $tgl]);
    if(!$cek){
        echo '<script>alert("Anda belum Check In, tidak bisa Check Out!");window.location="../presensi.php";</script>';
    } else {
        // update jam_pulang
        $data = array('jam_pulang' => $waktu);
        $proses->edit_data_presensi('tbl_presensi', $data, $id_login, $tgl);
        echo '<script>alert("Check Out berhasil!");window.location="../presensi.php";</script>';
    }
}

?>