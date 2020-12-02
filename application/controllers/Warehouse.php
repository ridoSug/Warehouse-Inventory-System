<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warehouse extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('m_warehouse');
        $this->load->model('m_user');
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Data Warehouse'
        ];

        $this->template->load('layout/v_layout', 'warehouse/v_warehouse', $data);
    }

    //
    public function get_ajax_data_warehouse()
    {
        //$data = $this->m_app->select_global('tb_warehouse', array('deletedate IS NULL' => NULL))->result_array();
        $data = $this->m_warehouse->get_data_warehouse()->result_array();
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
            'address' => $this->input->post('address'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
        );

        if ($id == '' || $id == NULL) {
            $id = $this->m_app->insert_global('tb_warehouse', $data);
            if ($id > 0) {
                echo json_encode(array(
                    'code' => 200,
                    'message' => 'Data Warehouse Berhasil Disimpan',
                    'data' => array()
                ));
            } else {
                echo json_encode(array(
                    'code' => 500,
                    'message' => 'Data Warehouse Gagal Disimpan',
                    'data' => array()
                ));
            }
        } else {
            $update = $this->m_app->update_global('tb_warehouse', array('id' => $id), $data);
            if ($update >= 0) {
                echo json_encode(array(
                    'code' => 200,
                    'message' => 'Data Warehouse Berhasil Disimpan',
                    'data' => array()
                ));
            } else {
                echo json_encode(array(
                    'code' => 500,
                    'message' => 'Data Warehouse Gagal Disimpan',
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

        $update = $this->m_app->update_global('tb_warehouse', array('id' => $id), $data);
        if ($update >= 0) {
            echo json_encode(array(
                'code' => 200,
                'message' => 'Data Warehouse Berhasil Dihapus',
                'data' => array()
            ));
        } else {
            echo json_encode(array(
                'code' => 500,
                'message' => 'Data Warehouse Gagal Dihapus',
                'data' => array()
            ));
        }
    }

    //locator

    public function locator($id_warehouse = '')
    {
        $data = [
            'title' => 'Manage Data Locator'
        ];

        if ($id_warehouse != '') {
            $data = [
                'title' => 'Manage Locator',
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
                $this->template->load('layout/v_layout', 'warehouse/v_locator', $data);
            } else {
                redirect(site_url('warehouse/locator'));
            }
        } else {
            $data = [
                'title' => 'Choose Warehouse',
                'tipe' => 'locator'
            ];
            $this->template->load('layout/v_layout', 'warehouse/v_choose_warehouse', $data);
        }
    }

    public function get_ajax_data_locator()
    {
        $id_warehouse = $this->input->post('id_warehouse');
        $data = $this->m_app->select_global('tb_warehouse_locator', array('id_warehouse' => $id_warehouse, 'deletedate IS NULL' => NULL))->result_array();
        //$data = $this->m_warehouse->get_data_warehouse()->result_array();
        $final['draw'] = 1;
        $final['recordsTotal'] = sizeof($data);
        $final['recordsFiltered'] = sizeof($data);
        $final['data'] = $data;
        echo json_encode($final);
    }

    public function save_data_locator()
    {
        $id = $this->input->post('id');

        $data = array(
            'name' => $this->input->post('name'),
            'id_warehouse' => $this->input->post('id_warehouse'),
        );

        //check duplicate name

        $where = array(
            'name' => $data['name'],
            'deletedate IS NULL' => NULL,
        );
        $check_data = $this->m_app->select_global('tb_warehouse_locator', $where);
        if ($check_data->num_rows() > 0) {
            echo json_encode(array(
                'code' => 500,
                'message' => 'Nama Unit Telah Terdaftar',
                'data' => array()
            ));
            return false;
        }

        if ($id == '' || $id == NULL) {
            $id = $this->m_app->insert_global('tb_warehouse_locator', $data);
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
            $update = $this->m_app->update_global('tb_warehouse_locator', array('id' => $id), $data);
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

    public function delete_data_locator()
    {
        $id = $this->input->post('id');

        $data = array(
            'deletedate' => date('Y-m-d')
        );

        $update = $this->m_app->update_global('tb_warehouse_locator', array('id' => $id), $data);
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

    //role warehouse
    public function role($id_warehouse = '')
    {
        $data = [
            'title' => 'Manage Data Warehouse Role'
        ];

        if ($id_warehouse != '') {
            $data = [
                'title' => 'Manage Data Warehouse Role'
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
                $this->template->load('layout/v_layout', 'warehouse/v_role', $data);
            } else {
                redirect(site_url('warehouse/role'));
            }
        } else {
            $data = [
                'title' => 'Choose Warehouse',
                'tipe' => 'role'
            ];
            $this->template->load('layout/v_layout', 'warehouse/v_choose_warehouse', $data);
        }
    }

    public function get_ajax_data_role()
    {
        $id_warehouse = $this->input->post('id_warehouse');
        //$data = $this->m_app->select_global('tb_warehouse_user', array('id_warehouse' => $id_warehouse))->result_array();
        $data = $this->m_warehouse->get_data_role(array('id_warehouse' => $id_warehouse))->result_array();
        $final['draw'] = 1;
        $final['recordsTotal'] = sizeof($data);
        $final['recordsFiltered'] = sizeof($data);
        $final['data'] = $data;
        echo json_encode($final);
    }

    public function save_data_role()
    {
        $id_warehouse = $this->input->post('id_warehouse');
        $id_user = $this->input->post('id_user');

        $data = array(
            'id_warehouse' => $id_warehouse,
            'id_user' => $id_user,
        );

        //check duplicate name

        $check_data = $this->m_app->select_global('tb_warehouse_user', $data);
        if ($check_data->num_rows() > 0) {
            echo json_encode(array(
                'code' => 500,
                'message' => 'Data Role Telah Terdaftar',
                'data' => array()
            ));
            return false;
        }

        //insert data
        $this->m_app->insert_global('tb_warehouse_user', $data);
        $check_data = $this->m_app->select_global('tb_warehouse_user', $data);
        if ($check_data->num_rows() > 0) {
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

    public function delete_data_role()
    {
        $id_warehouse = $this->input->post('id_warehouse');
        $id_user = $this->input->post('id_user');

        $data = array(
            'id_warehouse' => $id_warehouse,
            'id_user' => $id_user,
        );

        $delete = $this->m_app->delete_global('tb_warehouse_user', $data);
        if ($delete >= 0) {
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

    public function get_ajax_data_user()
    {
        // Search term
        $searchTerm     = $this->input->post('searchTerm');
        $id_warehouse   = $this->input->post('id_warehouse');

        $response       = $this->m_user->get_user_not_in_warehouse($searchTerm, $id_warehouse);

        echo json_encode($response);
    }
}
