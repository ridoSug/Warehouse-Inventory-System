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

    public function get_last_code()
    {
        $params = date('Ymd');
        $this->db->select('code');
        $this->db->from('tb_product');
        $this->db->like('code', $params, 'after');
        $this->db->order_by('code', 'desc');
        $data = $this->db->get();

        if ($data->num_rows() > 0) {
            $code = $data->row()->code;
            $cur_num = substr($code, strlen($params)) + 1;
            return $params . sprintf('%03d', $cur_num);
        } else {
            return $params . '001';
        }
    }

    public function get_data_product_select($term = '')
    {
        $this->db->select('tp.*, tpu.name uom');
        $this->db->from('tb_product tp');
        $this->db->join('tb_product_uom tpu', 'tp.id_uom=tpu.id');
        $this->db->like('tp.name', $term);
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
