<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_destination extends CI_Model
{
    public function get_data_destination($term = '')
    {
        $this->db->select('*');
        $this->db->from('tb_destination');
        $this->db->order_by('name');
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
}
