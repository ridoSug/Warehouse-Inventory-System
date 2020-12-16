<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inbound extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_inbound');
    }

    public function index()
    {
        $data  = [
            'title' => 'List Inbound'
        ];

        $this->template->load('layout/v_layout', 'inbound/v_list', $data);
    }

    public function get_inbound()
    {
        $order = 'arrival_date, arrival_time, inbound_no ASC';
        $data = $this->m_inbound->get_header(array(), $order)->result_array();
        $final['draw'] = 1;
        $final['recordsTotal'] = sizeof($data);
        $final['recordsFiltered'] = sizeof($data);
        $final['data'] = $data;
        echo json_encode($final);
    }

    public function get_inbound_confirm()
    {
        $data1 = $this->m_inbound->get_header(array('ti.arrival_date IS NULL' => NULL), 'inbound_no DESC, id ASC')->result_array();
        $data2 = $this->m_inbound->get_header(array('ti.arrival_date IS NOT NULL' => NULL), 'arrival_date DESC, inbound_no ASC')->result_array();
        $data = array_merge($data1, $data2);
        $final['draw'] = 1;
        $final['recordsTotal'] = sizeof($data);
        $final['recordsFiltered'] = sizeof($data);
        $final['data'] = $data;
        echo json_encode($final);
    }

    public function order($mode = 'add', $id_inbound = '')
    {
        switch ($mode) {
            case 'edit':

                $data_inbound = $this->m_app->select_global('tb_inbound', array('md5(id)' => $id_inbound));
                if ($data_inbound->num_rows() > 0) {
                    $data = [
                        'title'     => 'Edit Order Inbound',
                        'id'        => $id_inbound,
                        'id_user'   => $this->session->userdata('wh_id'),
                        'name_user' => $this->session->userdata('wh_name'),
                        'mode'      => $mode,
                    ];

                    $this->template->load('layout/v_layout', 'inbound/v_form_order', $data);
                } else {
                    redirect(site_url('inbound/'));
                }
                break;
            case 'list':
                break;
            case 'confirm':
                $data_inbound = $this->m_app->select_global('tb_inbound', array('md5(id)' => $id_inbound));

                if ($data_inbound->num_rows() > 0) {
                    $data = [
                        'title'     => 'Confirm Order Inbound',
                        'id'        => $id_inbound,
                        'id_user'   => $this->session->userdata('wh_id'),
                        'name_user' => $this->session->userdata('wh_name'),
                        'mode'      => $mode,
                    ];

                    $this->template->load('layout/v_layout', 'inbound/v_confirm_order', $data);
                } else {
                    redirect(site_url('inbound/confirm'));
                }
                break;
            case 'edit_confirm':
                $data_inbound = $this->m_app->select_global('tb_inbound', array('md5(id)' => $id_inbound));

                if ($data_inbound->num_rows() > 0) {
                    $data = [
                        'title'     => 'Edit Confirm Order Inbound',
                        'id'        => $id_inbound,
                        'id_user'   => $this->session->userdata('wh_id'),
                        'name_user' => $this->session->userdata('wh_name'),
                        'mode'      => $mode,
                    ];

                    $this->template->load('layout/v_layout', 'inbound/v_confirm_order', $data);
                } else {
                    redirect(site_url('inbound/confirm'));
                }
                break;
            default:

                $data = [
                    'title'     => 'New Order Inbound',
                    'id'        => '',
                    'id_user'   => $this->session->userdata('wh_id'),
                    'name_user' => $this->session->userdata('wh_name'),
                    'mode'      => $mode,
                ];

                $this->template->load('layout/v_layout', 'inbound/v_form_order', $data);
                break;
        }
    }

    public function save_order()
    {
        $id = $this->input->post('id');

        $data = array(
            'inbound_no'        => $this->m_inbound->get_last_no_inbound(),
            'inbound_date'      => $this->input->post('inbound_date'),
            'truck_no'          => $this->input->post('truck_no'),
            'driver_name'       => $this->input->post('driver_name'),
            'id_origin'         => $this->input->post('id_origin'),
            'id_warehouse'      => $this->input->post('id_warehouse'),
            'po_number'         => $this->input->post('po_number'),
            'id_user_created'   => $this->session->userdata('wh_id'),
        );

        //save header

        if ($id == '' || $id == null) {
            $id = $this->m_app->insert_global('tb_inbound', $data);

            if ($id <= 0) {
                echo json_encode(
                    [
                        'code' => 500,
                        'message' => 'Data Inbound Gagal Disimpan'
                    ]
                );
                return false;
            }
        } else {
            unset($data['inbound_no']);
            $this->m_app->update_global('tb_inbound', array('id' => $id), $data);
        }

        //data detail
        $id_detail  = $this->input->post('id_detail');
        $id_product = $this->input->post('id_product');
        $site_name  = $this->input->post('site_name');
        $qty        = $this->input->post('qty');
        $id_trash   = $this->input->post('id_trash');

        for ($i = 0; $i < sizeof($id_detail); $i++) {
            $data_detail = array(
                'id_inbound' => $id,
                'id_product' => $id_product[$i],
                'site_name'  => $site_name[$i],
                'qty'        => $qty[$i]
            );

            if ($id_detail[$i] == '0') {
                $this->m_app->insert_global('tb_inbound_detail', $data_detail);
            } else {
                $this->m_app->update_global('tb_inbound_detail', array('id' => $id_detail[$i]), $data_detail);
            }
        }

        //synchronize data trash
        $id_trash = explode(',', $id_trash);
        $this->m_inbound->sync_id_detail($id, $id_trash);

        $data_inbound = $this->m_app->select_global('tb_inbound', array('id' => $id));

        echo json_encode([
            'code' => 200,
            'message' => 'Data Inbound Berhasil Disimpan',
            'data' => $data_inbound->row_array(),
        ]);
    }

    public function info_order()
    {
        $id = $this->input->get('id');

        $header = $this->m_inbound->get_header(['md5(ti.id)' => $id]);
        $body   = $this->m_inbound->get_body(['md5(tid.id_inbound)' => $id]);

        if ($header->num_rows() > 0) {
            if ($body->num_rows() > 0) {
                echo json_encode(
                    [
                        'code'      => 200,
                        'message'   => 'DATA DITEMUKAN',
                        'header'    => $header->row_array(),
                        'body'      => $body->result_array()
                    ]
                );
            } else {
                echo json_encode(
                    [
                        'code'      => 404,
                        'message'   => 'DATA TIDAK DITEMUKAN',
                        'header'    => array(),
                        'body'      => array(),
                    ]
                );
            }
        } else {
            echo json_encode(
                [
                    'code'      => 404,
                    'message'   => 'DATA TIDAK DITEMUKAN',
                    'header'    => array(),
                    'body'      => array(),
                ]
            );
        }
    }

    public function confirm()
    {
        $data  = [
            'title' => 'Confirm Inbound'
        ];

        $this->template->load('layout/v_layout', 'inbound/v_list_confirm', $data);
    }

    public function save_confirm()
    {
        $id = $this->input->post('id');

        $data = array(
            'inbound_no'        => $this->m_inbound->get_last_no_inbound(),
            'inbound_date'      => $this->input->post('inbound_date'),
            'truck_no'          => $this->input->post('truck_no'),
            'driver_name'       => $this->input->post('driver_name'),
            'id_origin'         => $this->input->post('id_origin'),
            'id_warehouse'      => $this->input->post('id_warehouse'),
            'po_number'         => $this->input->post('po_number'),
            'id_user_created'   => $this->input->post('id_user_created'),
            'arrival_date'      => $this->input->post('arrival_date'),
            'arrival_time'      => $this->input->post('arrival_time'),
            'unloading_start'   => $this->input->post('unloading_start'),
            'unloading_finish'  => $this->input->post('unloading_finish'),
            'id_user_updated'   => $this->session->userdata('wh_id'),
            'wms_date'          => date('Y-m-d'),
            'wms_time'          => date('h:i')
        );

        //save header

        if ($id == '' || $id == null) {
            $id = $this->m_app->insert_global('tb_inbound', $data);

            if ($id <= 0) {
                echo json_encode(
                    [
                        'code' => 500,
                        'message' => 'Data Inbound Gagal Disimpan'
                    ]
                );
                return false;
            }
        } else {
            unset($data['inbound_no']);
            $this->m_app->update_global('tb_inbound', array('id' => $id), $data);
        }

        //data detail
        $id_detail  = $this->input->post('id_detail');
        $id_product = $this->input->post('id_product');
        $site_name  = $this->input->post('site_name');
        $qty        = $this->input->post('qty');
        $qty_good   = $this->input->post('qty_good');
        $qty_damage = $this->input->post('qty_damage');
        $id_locator = $this->input->post('id_locator');
        $id_trash   = $this->input->post('id_trash');

        for ($i = 0; $i < sizeof($id_detail); $i++) {
            $data_detail = array(
                'id_inbound' => $id,
                'id_product' => $id_product[$i],
                'site_name'  => $site_name[$i],
                'qty'        => $qty[$i],
                'qty_good'   => $qty_good[$i],
                'qty_damage' => $qty_damage[$i],
                'id_locator' => $id_locator[$i],
            );

            if ($id_detail[$i] == '0') {
                $this->m_app->insert_global('tb_inbound_detail', $data_detail);
            } else {
                $this->m_app->update_global('tb_inbound_detail', array('id' => $id_detail[$i]), $data_detail);
            }
        }

        //synchronize data trash
        $id_trash = explode(',', $id_trash);
        $this->m_inbound->sync_id_detail($id, $id_trash);
        $data_inbound = $this->m_app->select_global('tb_inbound', array('id' => $id));

        echo json_encode([
            'code' => 200,
            'message' => 'Data Inbound Berhasil Disimpan',
            'data' => $data_inbound->row_array(),
        ]);
    }
}
