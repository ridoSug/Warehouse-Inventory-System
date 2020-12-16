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

    public function get_data_warehouse_select($term = '')
    {
        $this->db->select('tw.*, md5(tw.id) md5_id');
        $this->db->from('tb_warehouse tw');
        $this->db->where('deletedate IS NULL');
        $this->db->like('name', $term);
        $this->db->order_by('name');
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

    public function get_data_locator_select($term = '', $id_wh = '')
    {
        $this->db->select('twl.id, twl.name');
        $this->db->from('tb_warehouse tw');
        $this->db->join('tb_warehouse_locator twl', 'tw.id=twl.id_warehouse');
        $this->db->where('tw.id', $id_wh);
        $this->db->where('twl.deletedate IS NULL', NULL, FALSE);
        $this->db->like('twl.name', $term);
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

    public function get_data_role($where)
    {
        $this->db->select('twu.*, tu.name name_user, tu.id_level, tul.name level, tu.username');
        $this->db->from('tb_warehouse_user twu');
        $this->db->join('tb_user tu', 'twu.id_user=tu.id');
        $this->db->join('tb_user_level tul', 'tu.id_level=tul.id');
        $this->db->where($where);
        return $this->db->get();
    }
}
