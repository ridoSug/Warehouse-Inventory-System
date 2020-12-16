<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Outbound extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_outbound');
    }
}
