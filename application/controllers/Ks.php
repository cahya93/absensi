<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ks extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect();
        }
        // is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('Admin_model');
        $this->load->model('Home_model');
        $this->load->model('Count_model', 'count');
        $this->load->model('Bk_model', 'bk');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('ks/wrapper/header', $data);
        $this->load->view('ks/wrapper/sidebar', $data);
        $this->load->view('ks/wrapper/topbar', $data);
        $this->load->view('ks/index', $data);
        $this->load->view('wrapper/footer');
    }
    public function profile()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'My Profile';
        $this->load->view('ks/wrapper/header', $data);
        $this->load->view('ks/wrapper/sidebar', $data);
        $this->load->view('ks/wrapper/topbar', $data);
        $this->load->view('ks/profile', $data);
        $this->load->view('wrapper/footer');
    }

    public function changepassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Password lama', 'required|trim');
        $this->form_validation->set_rules('password1', 'Password baru', 'required|trim|min_length[8]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Ulangi password', 'required|trim|min_length[8]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('ks/wrapper/header', $data);
            $this->load->view('ks/wrapper/sidebar', $data);
            $this->load->view('ks/wrapper/topbar', $data);
            $this->load->view('ks/change-password', $data);
            $this->load->view('wrapper/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password lama salah!!!</div>');
                redirect('ks/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password baru sama dengan yang lama!!!</div>');
                    redirect('ks/changepassword');
                } else {
                    //password ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password baru sama dengan yang lama!!!</div>');
                    redirect('ks/changepassword');
                }
            }
        }
    }

    //guru dan karyawan
    public function hr()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Daftar Absensi';
        $id = $this->input->get('level');
        $date = $this->input->get('date');
        $data['level'] = $this->db->get_where('tbl_status', ['id' => $id])->row_array();
        $data['data'] = $this->Admin_model->absen_hr($id, $date);
        $this->load->view('ks/wrapper/header', $data);
        $this->load->view('ks/wrapper/sidebar', $data);
        $this->load->view('ks/wrapper/topbar', $data);
        $this->load->view('ks/absen-harian', $data);
        $this->load->view('wrapper/footer');
    }
    public function edit_hr($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Edit Absensi Harian';
        $data['data'] = $this->db->get_where('tbl_dh', ['id' => $id])->row_array();

        $this->form_validation->set_rules('id', 'ID', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('ks/wrapper/header', $data);
            $this->load->view('ks/wrapper/sidebar', $data);
            $this->load->view('ks/wrapper/topbar', $data);
            $this->load->view('ks/edit-harian', $data);
            $this->load->view('wrapper/footer');
        } else {
            $this->Admin_model->edit_absen();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil diupdate!!!</div>');
            redirect('admin/edit_hr/' . $id);
        }
    }
    public function bln()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Daftar Absensi';
        $id = $this->input->get('status_id');
        $data['id'] = $id;
        $bulan = $this->input->get('bulan');
        $data['bulan'] = $this->db->get_where('tbl_hari_efektif', ['id' => $bulan])->row_array();
        $data['level'] = $this->db->get_where('tbl_status', ['id' => $id])->row_array();
        $data['data'] = $this->Admin_model->absen_bln($id);
        $this->load->view('ks/wrapper/header', $data);
        $this->load->view('ks/wrapper/sidebar', $data);
        $this->load->view('ks/wrapper/topbar', $data);
        $this->load->view('ks/absen-bulanan', $data);
        $this->load->view('wrapper/footer');
    }
    public function dtl_absn()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Daftar Absensi';
        $nbm = $this->input->get('nbm');
        $bulan = $this->input->get('bulan');
        $data['bulan'] = $this->db->get_where('tbl_hari_efektif', ['id' => $bulan])->row_array();
        $data['id'] = $this->db->get_where('user', ['no_reg' => $nbm])->row_array();
        $bulan = $this->input->get('bulan');
        $data['data'] = $this->Admin_model->detail_absen_bln($nbm, $bulan);
        $this->load->view('ks/wrapper/header', $data);
        $this->load->view('ks/wrapper/sidebar', $data);
        $this->load->view('ks/wrapper/topbar', $data);
        $this->load->view('ks/detail-absen-bulanan', $data);
        $this->load->view('wrapper/footer');
    }
    public function cetak_pdf_bln()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Daftar Absensi';
        $nama = $this->input->get('nama');
        $nbm = $this->input->get('nbm');
        $data['id'] = $this->db->get_where('user', ['no_reg' => $nbm])->row_array();
        $bulan = $this->input->get('bulan');
        $data['bulan'] = $bulan;
        $data['data'] = $this->Admin_model->detail_absen_bln($nbm, $bulan);
        $this->load->view('ks/cetak-pdf-bulanan', $data);

        $mpdf = new \Mpdf\Mpdf(
            [
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'setAutoTopMargin' => false
            ]
        );

        // $mpdf->SetHTMLHeader('
        // <div style="text-align: center; font-weight: bold;">
        //   <img src="assets/img/pi-2020.png" width="100%" height="100%" />
        // </div>');

        $html = $this->load->view('admin/cetak-pdf-bulanan', [], true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Detail Absensi ' . $nama . '.pdf', \Mpdf\Output\Destination::INLINE);
    }
    public function cetak_all_bln()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Daftar Absensi';
        $bulan = $this->input->get('bulan');
        $id = $this->input->get('id');
        $data['bulan'] = $bulan;
        $data['data'] = $this->Admin_model->detail_all_bln($id);
        $this->load->view('ks/cetak-all-bulanan', $data);

        $mpdf = new \Mpdf\Mpdf(
            [
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'setAutoTopMargin' => false
            ]
        );

        // $mpdf->SetHTMLHeader('
        // <div style="text-align: center; font-weight: bold;">
        //   <img src="assets/img/pi-2020.png" width="100%" height="100%" />
        // </div>');

        $html = $this->load->view('ks/cetak-all-bulanan', [], true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Detail Absensi.pdf', \Mpdf\Output\Destination::INLINE);
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_dh');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data berhasil dihapus!!!</div>');
        redirect('admin');
    }
}
