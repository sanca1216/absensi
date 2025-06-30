<?php 
class prosesCrud {

    protected $db;
    function __construct($db){
        $this->db = $db;
    }

    function proses_login($user, $pass)
    {
        // untuk password kita enkripsi dengan md5
        $row = $this->db->prepare('SELECT * FROM tbl_user WHERE username=? AND password=md5(?)');
        $row->execute(array($user, $pass));
        $count = $row->rowCount();
        if ($count > 0) {
            return $hasil = $row->fetch();
        } else {
            return 'gagal';
        }
    }

    function tampil_data($tabel)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel");
        $row->execute();
        return $hasil = $row->fetchAll();
    }

    function tampil_data_id($tabel, $where, $id)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel WHERE $where = ?");
        $row->execute(array($id));
        return $hasil = $row->fetch();
    }

    function tambah_data($tabel, $data)
    {
        // buat array untuk isi values insert
        $rowsSQL = array();
        $toBind = array();
        $columnNames = array_keys($data[0]);

        foreach ($data as $arrayIndex => $row) {
            $params = array();
            foreach ($row as $columnName => $columnValue) {
                $param = ":" . $columnName . $arrayIndex;
                $params[] = $param;
                $toBind[$param] = $columnValue;
            }
            $rowsSQL[] = "(" . implode(", ", $params) . ")";
        }

        $sql = "INSERT INTO $tabel (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $rowsSQL);
        $row = $this->db->prepare($sql);
        foreach ($toBind as $param => $val) {
            $row->bindValue($param, $val);
        }
        return $row->execute();
    }

    function edit_data($tabel, $data, $where, $id)
    {
        $setPart = array();
        foreach ($data as $key => $value) {
            $setPart[] = $key . "=:" . $key;
        }
        $sql = "UPDATE $tabel SET " . implode(', ', $setPart) . " WHERE $where = :id";
        $row = $this->db->prepare($sql);
        $row->bindValue(':id', $id);
        foreach ($data as $param => $val) {
            $row->bindValue($param, $val);
        }
        return $row->execute();
    }

    function hapus_data($tabel, $where, $id)
    {
        $sql = "DELETE FROM $tabel WHERE $where = ?";
        $row = $this->db->prepare($sql);
        return $row->execute(array($id));
    }

    // Tampil data query (ambil 1 baris saja)
    function tampil_data_query($query, $param=[])
    {
        $row = $this->db->prepare($query);
        $row->execute($param);
        return $row->fetch();
    }

    // Tampil data query (ambil semua baris)
    function tampil_data_query_all($query, $param=[])
    {
        $row = $this->db->prepare($query);
        $row->execute($param);
        return $row->fetchAll();
    }

    // Edit data khusus presensi
    function edit_data_presensi($tabel, $data, $id_login, $tgl)
    {
        $setPart = array();
        foreach ($data as $key => $value) {
            $setPart[] = $key . "=:" . $key;
        }
        $sql = "UPDATE $tabel SET " . implode(', ', $setPart) . " WHERE id_login=:id_login AND tgl_presensi=:tgl_presensi";
        $row = $this->db->prepare($sql);
        $row->bindValue(':id_login', $id_login);
        $row->bindValue(':tgl_presensi', $tgl);
        foreach ($data as $param => $val) {
            $row->bindValue($param, $val);
        }
        return $row->execute();
    }
}
?>
