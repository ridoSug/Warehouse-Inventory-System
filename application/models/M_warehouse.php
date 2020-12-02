<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_warehouse extends CI_Model
{
    public function get_data_warehouse($where = array())
    {
        $this->db->select('tw.*, md5(tw.id) md5_id');
        $this->db->from('tb_warehouse tw');
        $this->db->where('deletedate IS NULL');
        $this->db->where($where);
        return $this->db->get();
    }

    public function get_data_role($where)
    {
        $this->db->select('twu.*, tu.name name_user');
        $this->db->from('tb_warehouse_user twu');
        $this->db->join('tb_user tu', 'twu.id_user=tu.id');
        $this->db->where($where);
        return $this->db->get();
    }
}
