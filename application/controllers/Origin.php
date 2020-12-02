<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Origin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('m_origin');
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Data Origin'
        ];

        $this->template->load('layout/v_layout', 'origin/v_origin', $data);
    }

    public function get_ajax_data_origin()
    {
        $data = $this->m_app->select_global('tb_origin', array('deletedate IS NULL' => NULL))->result_array();
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
        );

        if ($id == '' || $id == NULL) {
            $id = $this->m_app->insert_global('tb_origin', $data);
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
            $update = $this->m_app->update_global('tb_origin', array('id' => $id), $data);
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

        $update = $this->m_app->update_global('tb_origin', array('id' => $id), $data);
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
}
