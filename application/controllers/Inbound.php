<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inbound extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function order($mode = 'add', $id_inbound = '')
    {
        switch ($mode) {
            case 'edit':

                $data = [
                    'title' => 'Edit Order Inbound',
                    'id'  => $id_inbound,
                    'id_user' => $this->session->userdata('wh_id'),
                    'name_user' => $this->session->userdata('wh_name'),
                ];

                $this->template->load('layout/v_layout', 'inbound/v_order', $data);

                break;

            default:

                $data = [
                    'title' => 'New Order Inbound',
                    'id'  => '',
                    'id_user' => $this->session->userdata('wh_id'),
                    'name_user' => $this->session->userdata('wh_name'),
                ];

                $this->template->load('layout/v_layout', 'inbound/v_order', $data);
                break;
        }
    }
}
