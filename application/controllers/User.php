<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('m_user');
    }

    public function index()
    {
        $data = [
            'title' => 'Manage User Data'
        ];

        $this->template->load('layout/v_layout', 'user/v_user', $data);
    }

    //get ajax select2 
    public function get_ajax_data()
    {
        // Search term
        $searchTerm     = $this->input->post('searchTerm');

        $response       = $this->m_user->get_array_id_level($searchTerm);

        echo json_encode($response);
    }

    public function get_ajax_data_user()
    {
        $data = $this->m_user->get_data_user()->result_array();
        $final['draw'] = 1;
        $final['recordsTotal'] = sizeof($data);
        $final['recordsFiltered'] = sizeof($data);
        $final['data'] = $data;
        echo json_encode($final);
    }

    //simpan data user
    public function save_data()
    {
        $id = $this->input->post('id');

        $data = [
            'username' => $this->input->post('username'),
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'id_level' => $this->input->post('id_level'),
            'status' => $this->input->post('status'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        ];

        //check username
        $check_data = $this->m_app->select_global('tb_user', array('username' => $data['username'], 'id!=' => $id, 'deletedate IS NULL' => NULL));
        if ($check_data->num_rows() > 0) {
            echo json_encode(array(
                'code' => 500,
                'message' => 'Username sudah ada',
                'data' => array()
            ));
            return false;
        }

        if ($id == '' || $id == null) {
            //insert new record
            $id = $this->m_app->insert_global('tb_user', $data);
            if ($id > 0) {
                echo json_encode(array(
                    'code' => 200,
                    'message' => 'Data User Berhasil Disimpan',
                    'data' => array()
                ));
            } else {
                echo json_encode(array(
                    'code' => 500,
                    'message' => 'Data User Gagal Disimpan',
                    'data' => array()
                ));
            }
        } else {
            //update existing
            if (strlen($this->input->post('password')) == 0) {
                unset($data['password']);
            }
            $update = $this->m_app->update_global('tb_user', array('id' => $id), $data);
            if ($update >= 0) {
                echo json_encode(array(
                    'code' => 200,
                    'message' => 'Data User Berhasil Disimpan',
                    'data' => array()
                ));
            } else {
                echo json_encode(array(
                    'code' => 500,
                    'message' => 'Data User Gagal Disimpan',
                    'data' => array()
                ));
            }
        }
    }

    //hapus data user

    public function delete_data()
    {
        $id = $this->input->post('id');

        $data = array(
            'deletedate' => date('Y-m-d')
        );

        $update = $this->m_app->update_global('tb_user', array('id' => $id), $data);

        if ($update >= 0) {
            echo json_encode(array(
                'code' => 200,
                'message' => 'Data User Berhasil Dihapus',
                'data' => array()
            ));
        } else {
            echo json_encode(array(
                'code' => 500,
                'message' => 'Data User Gagal Dihapus',
                'data' => array()
            ));
        }
    }
}
