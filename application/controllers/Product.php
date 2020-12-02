<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('m_product');
    }

    public function index($id_warehouse = '')
    {
        if ($id_warehouse != '') {
            $data = [
                'title' => 'Manage Product',
            ];
            //cari id warehouse
            $where = array(
                'md5(id)' => $id_warehouse,
                'deletedate IS NULL' => NULL
            );
            $data_warehouse = $this->m_app->select_global('tb_warehouse', $where);
            if ($data_warehouse->num_rows() > 0) {
                $data['id_warehouse'] = $data_warehouse->row()->id;
                $data['data_warehouse'] = $data_warehouse->row_array();
                $this->template->load('layout/v_layout', 'product/v_product', $data);
            } else {
                redirect(site_url('product'));
            }
        } else {
            $data = [
                'title' => 'Choose Warehouse',
            ];
            $this->template->load('layout/v_layout', 'product/v_warehouse', $data);
        }
    }

    public function get_ajax_data()
    {
        $id_warehouse = $this->input->post('id_warehouse');
        $where = [
            'tp.id_warehouse' => $id_warehouse
        ];
        $data = $this->m_product->get_data_product($where)->result_array();
        $final['draw'] = 1;
        $final['recordsTotal'] = sizeof($data);
        $final['recordsFiltered'] = sizeof($data);
        $final['data'] = $data;
        echo json_encode($final);
    }

    public function save_data()
    {
        $id = $this->input->post('id');

        $data = array(
            'name' => $this->input->post('name'),
            'id_uom' => $this->input->post('id_uom'),
            'id_warehouse' => $this->input->post('id_warehouse'),
        );

        //check duplicate name

        $where = array(
            'name' => $data['name'],
            'deletedate IS NULL' => NULL,
        );
        $check_data = $this->m_app->select_global('tb_product', $where);

        if ($check_data->num_rows() > 0) {
            echo json_encode(array(
                'code' => 500,
                'message' => 'Nama Unit Telah Terdaftar',
                'data' => array()
            ));
            return false;
        }

        if ($id == '' || $id == NULL) {
            $id = $this->m_app->insert_global('tb_product', $data);
            if ($id > 0) {
                echo json_encode(array(
                    'code' => 200,
                    'message' => 'Data Berhasil Disimpan',
                    'data' => array()
                ));
            } else {
                echo json_encode(array(
                    'code' => 500,
                    'message' => 'Data Gagal Disimpan',
                    'data' => array()
                ));
            }
        } else {
            $update = $this->m_app->update_global('tb_product', array('id' => $id), $data);
            if ($update >= 0) {
                echo json_encode(array(
                    'code' => 200,
                    'message' => 'Data Berhasil Disimpan',
                    'data' => array()
                ));
            } else {
                echo json_encode(array(
                    'code' => 500,
                    'message' => 'Data Gagal Disimpan',
                    'data' => array()
                ));
            }
        }
    }

    public function delete_data()
    {
        $id = $this->input->post('id');

        $data = array(
            'deletedate' => date('Y-m-d')
        );

        $update = $this->m_app->update_global('tb_product', array('id' => $id), $data);
        if ($update >= 0) {
            echo json_encode(array(
                'code' => 200,
                'message' => 'Data Berhasil Dihapus',
                'data' => array()
            ));
        } else {
            echo json_encode(array(
                'code' => 500,
                'message' => 'Data Gagal Dihapus',
                'data' => array()
            ));
        }
    }

    public function uom()
    {
        $data = [
            'title' => 'Manage Unit Product'
        ];

        $this->template->load('layout/v_layout', 'product/v_product_uom', $data);
    }

    public function get_ajax_data_uom()
    {
        $data = $this->m_app->select_global('tb_product_uom', array('deletedate IS NULL' => NULL))->result_array();
        $final['draw'] = 1;
        $final['recordsTotal'] = sizeof($data);
        $final['recordsFiltered'] = sizeof($data);
        $final['data'] = $data;
        echo json_encode($final);
    }

    public function save_data_uom()
    {
        $id = $this->input->post('id');

        $data = array(
            'name' => $this->input->post('name'),
        );

        //check duplicate name

        $where = array(
            'name' => $data['name'],
            'deletedate IS NULL' => NULL,
        );
        $check_data = $this->m_app->select_global('tb_product_uom', $where);
        if ($check_data->num_rows() > 0) {
            echo json_encode(array(
                'code' => 500,
                'message' => 'Nama Unit Telah Terdaftar',
                'data' => array()
            ));
            return false;
        }

        if ($id == '' || $id == NULL) {
            $id = $this->m_app->insert_global('tb_product_uom', $data);
            if ($id > 0) {
                echo json_encode(array(
                    'code' => 200,
                    'message' => 'Data Berhasil Disimpan',
                    'data' => array()
                ));
            } else {
                echo json_encode(array(
                    'code' => 500,
                    'message' => 'Data Gagal Disimpan',
                    'data' => array()
                ));
            }
        } else {
            $update = $this->m_app->update_global('tb_product_uom', array('id' => $id), $data);
            if ($update >= 0) {
                echo json_encode(array(
                    'code' => 200,
                    'message' => 'Data Berhasil Disimpan',
                    'data' => array()
                ));
            } else {
                echo json_encode(array(
                    'code' => 500,
                    'message' => 'Data Gagal Disimpan',
                    'data' => array()
                ));
            }
        }
    }

    public function delete_data_uom()
    {
        $id = $this->input->post('id');

        $data = array(
            'deletedate' => date('Y-m-d')
        );

        $update = $this->m_app->update_global('tb_product_uom', array('id' => $id), $data);
        if ($update >= 0) {
            echo json_encode(array(
                'code' => 200,
                'message' => 'Data Berhasil Dihapus',
                'data' => array()
            ));
        } else {
            echo json_encode(array(
                'code' => 500,
                'message' => 'Data Gagal Dihapus',
                'data' => array()
            ));
        }
    }

    public function get_ajax_data_select_uom()
    {
        // Search term
        $searchTerm     = $this->input->post('searchTerm');

        $response       = $this->m_product->get_array_id_uom($searchTerm);

        echo json_encode($response);
    }
}
