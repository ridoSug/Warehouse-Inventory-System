<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_app extends CI_Model
{
    public function select_global($table, $key = array(), $ordercol = "", $sorter = "asc")
    {
        $this->db->where($key);
        $this->db->from($table);
        if (!empty($ordercol)) {
            $this->db->order_by($ordercol, $sorter);
        }
        $result = $this->db->get();
        return $result;
    }

    public function insert_global($table, $data = array())
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function insert_batch_global($table, $data = array())
    {
        return $this->db->insert_batch($table, $data);
    }

    public function delete_global($table, $key = array())
    {
        $this->db->where($key);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function update_global($table, $key = array(), $field = array())
    {
        $this->db->where($key);
        $this->db->update($table, $field);
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }
}
