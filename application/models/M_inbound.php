<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_inbound extends CI_Model
{
    public function get_last_no_inbound()
    {
        $params = date('Ymd') . 'In';
        $this->db->select('inbound_no');
        $this->db->from('tb_inbound');
        $this->db->like('inbound_no', $params, 'after');
        $this->db->order_by('inbound_no', 'desc');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            $code = $data->row()->inbound_no;
            $cur_num = substr($code, strlen($params)) + 1;
            return $params . sprintf('%04d', $cur_num);
        } else {
            return $params . '0001';
        }
    }

    public function sync_id_detail($id_inbound, $id_trash)
    {
        $this->db->where_in('id', $id_trash);
        $this->db->where('id_inbound', $id_inbound);
        $this->db->update('tb_inbound_detail', array('deletedate' => date('Y-m-d')));
        return $this->db->affected_rows();
    }

    public function get_header($where = array(), $order = '')
    {
        $this->db->select('ti.*, md5(ti.id) md5_id, tw.name warehouse, to.name origin, tu_1.name name_creator');
        $this->db->from('tb_inbound ti');
        $this->db->join('tb_inbound_detail tid', 'ti.id=tid.id_inbound');
        $this->db->join('tb_Warehouse tw', 'ti.id_warehouse=tw.id');
        $this->db->join('tb_origin to', 'ti.id_origin=to.id');
        $this->db->join('tb_user tu_1', 'ti.id_user_created=tu_1.id');
        $this->db->join('tb_user tu_2', 'ti.id_user_created=tu_2.id');
        $this->db->where($where);
        $this->db->order_by($order);
        $this->db->group_by('ti.id');
        return $this->db->get();
    }

    public function get_body($where = array())
    {
        $this->db->select('tid.*, tp.name product, twl.name locator, tpu.name uom');
        $this->db->from('tb_inbound_detail tid');
        $this->db->join('tb_product tp', 'tid.id_product=tp.id');
        $this->db->join('tb_product_uom tpu', 'tp.id_uom=tpu.id');
        $this->db->join('tb_warehouse_locator twl', 'tid.id_locator=twl.id', 'LEFT');
        $this->db->where($where);
        $this->db->where('tid.deletedate IS NULL', NULL, FALSE);
        return $this->db->get();
    }
}
