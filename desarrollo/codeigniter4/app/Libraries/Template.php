<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template
{
	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function load($view, $data = [])
	{
		$this->CI->load->view('header', $data);
		$this->CI->load->view($view, $data);
		$this->CI->load->view('footer');
	}
}
