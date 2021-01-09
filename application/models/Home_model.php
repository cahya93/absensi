<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends CI_Model
{
    function getNIS()
    {
        $this->db->order_by('nis', 'ASC');
        return $this->db->get_where('tbl_siswa')->result_array();
    }
    function nama_siswa($nis)
    {
        $this->db->where('nis', $nis);
        $result = $this->db->get('tbl_siswa')->result();
        return $result;
    }

    function getNBM()
    {
        $this->db->order_by('no_reg', 'ASC');
        return $this->db->get_where('user')->result_array();
    }
    function nama($nbm)
    {
        $this->db->where('no_reg', $nbm);
        $result = $this->db->get('user')->result();
        return $result;
    }

    function getKegiatan()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('tbl_kegiatan')->result_array();
    }
}
