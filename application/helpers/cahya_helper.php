<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
if (!function_exists('akun')) {
    function akun($akun)
    {
        switch ($akun) {
            case 0:
                $akun = "Null";
                break;
            case 1:
                $akun = "Administrator";
                break;
            case 2:
                $akun = "Admin Absensi";
                break;
            case 3:
                $akun = "Guru";
                break;
            case 4:
                $akun = "Karyawan";
                break;
            case 5:
                $akun = "Siswa";
                break;
            case 6:
                $akun = "Admin BK";
                break;
            case 7:
                $akun = "Ketua Komptensi Keahlian";
                break;
            case 11:
                $akun = "Bendahara";
                break;
            case 12:
                $akun = "Admin Lab Komputer";
                break;
        }
        return $akun;
    }
}
if (!function_exists('status')) {
    function status($status)
    {
        switch ($status) {
            case 3:
                $status = "Guru";
                break;
            case 4:
                $status = "Karyawan";
                break;
            case 5:
                $status = "Siswa";
                break;
        }
        return $status;
    }
}
if (!function_exists('jurusan')) {
    function jurusan($jurusan)
    {
        switch ($jurusan) {
            case 1:
                $jurusan = "Teknik Kendaraan Ringan Otomotif";
                break;
            case 2:
                $jurusan = "Teknik Bisnis Sepda Motor";
                break;
            case 3:
                $jurusan = "Akuntansi dan Keuangan Lembaga";
                break;
            case 4:
                $jurusan = "Otomomatisasi dan Tata Kelola Perkantoran";
                break;
            case 5:
                $jurusan = "Bisnis Daring dan Pemasaran";
                break;
        }
        return $jurusan;
    }
}

function convRupiah($value) {
  return 'Rp ' . number_format($value).'.00';
}

function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}