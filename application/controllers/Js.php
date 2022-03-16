<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Js extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Home_model');
        $this->load->model('Count_model');
        $this->load->model('Js_model');
    }
    public function getDetailsGukar(){
        $nbm = $this->input->get('nbm');
        $data = $this->Js_model->getDetailGukar($nbm);
        echo json_encode($data);
    }

    public function presensiMasuk(){
        $nbm = $this->input->get('id');
        $dateIn = $this->input->get('dateIn');
        $data = $this->Js_model->presensiMasuk($nbm, $dateIn);
        echo json_encode($data);
    }

    public function presensiPulang(){
        $nbm = $this->input->get('id');
        $dateIn = $this->input->get('dateIn');
        $data = $this->Js_model->presensiPulang($nbm, $dateIn);
        echo json_encode($data);
    }
    public function insert_DH()
    {
        $nbm = $_POST['nbm'];
        $bulan = $_POST['bulan'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $roleId = $_POST['role_id'];
        $year = $_POST['year'];
        $data = [
            'nbm' => $nbm,
            'bulan' => $bulan,
            'date_in' => $date,
            'time_in' => $time,
            'role_id' => $roleId,
            'year'=>$year
        ];

        $this->db->insert('tbl_dh', $data);
    }

    public function update_DH()
    {
        $nbm = $_POST['nbm'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $data = [
            'date_out' => $date,
            'time_out' => $time,
        ];
        $this->db->where('nbm', $nbm);
        $this->db->where('date_in', $date);
        $this->db->update('tbl_dh', $data);
    }
    
    public function getMotivation(){
        $id = $this->input->get('id');
        $data = $this->Js_model->getMotivasi($id);
        echo json_encode($data);
    }

    public function getEvent(){
        $date = $this->input->get('tgl');
        $data = $this->Js_model->getEvent($date);
        echo json_encode($data);
    }

    public function cekEvent($eventId){
        $data = $this->Js_model->cekEvent($eventId);
        echo json_encode($data);
    }
    
    public function getDetailDHEvent($userId, $eventId, $today){
        $data = $this->Js_model->getDetailDHEvent($userId, $eventId, $today);
        echo json_encode($data);
    }
    
    public function saveDhEvent()
    {
        $eventId = $this->input->post('eventId');
        $userId = $this->input->post('userId');
        $status = $this->input->post('status');
        $tgl = $this->input->post('date');
        $data = [
            'id_kegiatan' => $eventId,
            'no_id' => $userId,
            'status'=> $status,
            'tgl' => $tgl
        ];
        $this->db->insert('tbl_dh_kegiatan', $data);
    }
    //data lama
    public function nama_siswa(){
        $nis = $this->input->get('nis');
        $data = $this->Home_model->nama_siswa($nis);
        foreach ($data as $data) {
            $lists =
                "<option value='" .
                $data->nama .
                "'>" .
                $data->nama .
                '</option>';
        }
        $callback = ['list_nama' => $lists];
        echo json_encode($callback);
    }

    public function kelas()
    {
        $nis = $this->input->get('nis');
        $data = $this->Home_model->nama_siswa($nis);
        foreach ($data as $data) {
            $lists =
                "<option value='" .
                $data->kelas .
                "'>" .
                $data->kelas .
                '</option>';
        }
        $callback = ['list_nama' => $lists];
        echo json_encode($callback);
    }

    public function level_siswa()
    {
        $nis = $this->input->get('nis');
        $data = $this->Home_model->nama_siswa($nis);
        foreach ($data as $data) {
            $lists =
                "<option value='" .
                $data->level .
                "'>" .
                status($data->level) .
                '</option>';
        }
        $callback = ['list_nama' => $lists];
        echo json_encode($callback);
    }

    public function insert_DHS()
    {
        $img = $_POST['image'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file =
            './signature-image/daftar-hadir/siswa/masuk/' . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        $image = str_replace('./', '', $file);

        // $id = $_POST['id'];
        $tp = $_POST['tp'];
        $semester = $_POST['semester'];
        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $bulan = $_POST['bulan'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $status = $_POST['status'];
        $alasan = $_POST['alasan'];
        $level = $_POST['level'];
        $data = [
            'ttd_in' => $image,
            'nbm' => $nis,
            'nama' => $nama,
            'kelas' => $kelas,
            'bulan' => $bulan,
            'date_in' => $date,
            'time_in' => $time,
            'status' => $status,
            'alasan' => $alasan,
            'level' => $level,
            'tp' => $tp,
            'semester' => $semester,
        ];
        $this->db->insert('tbl_dh', $data);

        $master = [
            'nama' => $nama,
            'kegiatan' =>
                'Mengisi daftar hadir tanggal ' .
                $date .
                '<br/>' .
                'Jam masuk ' .
                $time .
                '<br/>' .
                'Status Kehadiran :' .
                $status .
                '<br/>' .
                'Alasan ' .
                $alasan,
        ];
        $this->db->insert('aktivitas', $master);
    }

    public function update_DHS()
    {
        $img = $_POST['image'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file =
            './signature-image/daftar-hadir/siswa/pulang/' . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        $image = str_replace('./', '', $file);

        // $id = $_POST['id'];
        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $level = $_POST['level'];
        $id = $_POST['id'];
        $data = [
            'ttd_out' => $image,
            'time_out' => $time,
        ];
        $this->db->where('nbm', $nis);
        $this->db->where('date_in', $date);
        $this->db->update('tbl_dh', $data);

        $master = [
            'nama' => $nama,
            'kegiatan' =>
                'Mengisi daftar pualng tanggal ' .
                $date .
                '<br/>' .
                'Jam pulang ' .
                $time,
        ];
        $this->db->insert('aktivitas', $master);
    }

    //guru
    public function nama()
    {
        $nbm = $this->input->get('nbm');
        $iduka = $this->Home_model->nama($nbm);
        foreach ($iduka as $data) {
            $lists =
                "<option value='" .
                $data->nama .
                "'>" .
                $data->nama .
                '</option>';
        }
        $callback = ['list_nama' => $lists];
        echo json_encode($callback);
    }

    public function email()
    {
        $nbm = $this->input->get('nbm');
        $iduka = $this->Home_model->nama($nbm);
        foreach ($iduka as $data) {
            $lists =
                "<option value='" .
                $data->email .
                "'>" .
                $data->email .
                '</option>';
        }
        $callback = ['list_email' => $lists];
        echo json_encode($callback);
    }

    public function status()
    {
        $nbm = $this->input->get('nbm');
        $iduka = $this->Home_model->nama($nbm);
        foreach ($iduka as $data) {
            $lists =
                "<option value='" .
                $data->status .
                "'>" .
                status($data->status) .
                '</option>';
        }
        $callback = ['list_level' => $lists];
        echo json_encode($callback);
    }

    public function insert_DH_kegiatan()
    {
        $img = $_POST['image'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = './signature-image/daftar-hadir-kegiatan/' . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        $image = str_replace('./', '', $file);

        $id_keg = $_POST['id_keg'];
        $no_id = $_POST['no_id'];
        $nama = $_POST['nama'];
        $tgl = $_POST['date'];
        $status = $_POST['status'];
        $alasan = $_POST['alasan'];
        $status_id = $_POST['status_id'];
        $data = [
            'id_kegiatan' => $id_keg,
            'no_id' => $no_id,
            'nama' => $nama,
            'tgl' => $tgl,
            'status' => $status,
            'alasan' => $alasan,
            'ttd' => $image,
            'status_id' => $status_id,
        ];
        $this->db->insert('tbl_dh_kegiatan', $data);

        $master = [
            'nama' => $nama,
            'kegiatan' =>
                'Mengisi daftar kegiatan tanggal ' .
                $tgl .
                '<br/>' .
                // 'Nama kegiatan :' . $kegiatan . '<br/>' .
                'Status Kehadiran :' .
                $status .
                '<br/>' .
                'Alasan :' .
                $alasan,
        ];
        $this->db->insert('aktivitas', $master);
    }

    // kelas
    function getKelas()
    {
        $jurusan = $this->input->get('jurusan');
        $result = $this->Js_model->getKelas($jurusan);
        foreach ($result as $data) {
            $lists =
                "<option value='" .
                $data->kelas .
                "'>" .
                $data->kelas .
                '</option>';
        }
        $callback = ['list_kelas' => $lists];
        echo json_encode($callback);
    }
    //BK
    // public function tbh_siswa()
    // {
    //     $kelas = $this->input->get('kelas');
    //     $result = $this->Home_model->tbh_siswa($kelas);
    //     foreach ($result as $data) {
    //         $lists = "<option value='" . $data->nama . "'>" . $data->nama . "</option>";
    //     }
    //     $callback = array('list_nama' => $lists);
    //     echo json_encode($callback);
    // }
    public function insert_surat()
    {
        $img = $_POST['image'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = './signature-image/surat-pernyataan/' . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        $image = str_replace('./', '', $file);

        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $hp_siswa = $_POST['hp_siswa'];
        $kelas = $_POST['kelas'];
        $nama_ortu = $_POST['nama_ortu'];
        $alamat_ortu = $_POST['alamat_ortu'];
        $hp_ortu = $_POST['hp_ortu'];
        $date = $_POST['date'];
        $data = [
            'ttd' => $image,
            'nis' => $nis,
            'nama_siswa' => $nama,
            'hp_siswa' => $hp_siswa,
            'kelas' => $kelas,
            'nama_ortu' => $nama_ortu,
            'alamat_ortu' => $alamat_ortu,
            'hp_ortu' => $hp_ortu,
            'date' => $date,
        ];
        $this->db->insert('tbl_surat_pernyataan', $data);
    }
}