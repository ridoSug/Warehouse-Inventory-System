<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_product extends CI_Model
{
    public function get_array_id_uom($term)
    {
        $this->db->select('*');
        $this->db->from('tb_product_uom');
        $this->db->like('name', $term);
        $this->db->where('deletedate IS NULL', NULL, FALSE);
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

    public function get_data_product()
    {
        $this->db->select('tp.*, tpu.name uom');
        $this->db->from('tb_product tp');
        $this->db->join('tb_product_uom tpu', 'tp.id_uom=tpu.id');
        $this->db->where('tp.deletedate IS NULL', NULL);
        return $this->db->get();
    }
}
