<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
    public function get_array_id_level($term)
    {
        $this->db->select('*');
        $this->db->from('tb_user_level');
        $this->db->like('name', $term);
        $data = $this->db->get();

        $dd = array();
        $i = 0;
        foreach ($data->result_array() as $key => $value) {
            $dd[] = $value;
            $dd[$i]['text'] = $value['name'];
            $i++;
        }
        return $dd;
    }

    public function get_user_not_in_warehouse($term, $id_warehouse)
    {
        //select warehouse_user
        $this->db->select('id_user');
        $this->db->from('tb_warehouse_user twu');
        $this->db->where('id_warehouse', $id_warehouse);
        $this->db->where('twu.id_user=tu.id');
        $twu = $this->db->get_compiled_select();

        $this->db->select('*');
        $this->db->from('tb_user tu');
        $this->db->where("NOT EXISTS ($twu)", NULL, FALSE);
        $this->db->like('name', $term);
        $this->db->where('tu.deletedate IS NULL', NULL, FALSE);
        $this->db->where('tu.status', '1');
        $data = $this->db->get();

        $dd = array();
        $i = 0;
        foreach ($data->result_array() as $key => $value) {
            $dd[] = $value;
            $dd[$i]['text'] = $value['name'];
            $i++;
        }
        return $dd;
    }

    public function get_data_user()
    {
        $this->db->select('tu.id, tu.username, tu.name, tu.id_level, tul.name level, tu.status, tu.email');
        $this->db->from('tb_user tu');
        $this->db->join('tb_user_level tul', 'tu.id_level=tul.id');
        $this->db->where('tu.deletedate IS NULL', NULL, FALSE);
        return $this->db->get();
    }
}
