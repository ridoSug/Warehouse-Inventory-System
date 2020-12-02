<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		check_login();
	}

	public function index()
	{
		$this->template->load('layout/v_layout', 'welcome/v_dashboard');
	}
}
