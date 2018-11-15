<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
			parent::__construct();
			$this->load->model('User_Model');
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function userRegister() {
		//print_r('this works');
		//die();
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = sha1($this->input->post('password'));

		$result = $this->User_Model->userRegister($username, $email, $password);

		if($result != FALSE) {
			echo json_encode($result);
		}
	}

	public function userLogin() {
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password'));

		$result = $this->User_Model->userLogin($username, $password);
		//print_r($result);
		//die();
		if($result != FALSE) {
			$newdata = array(
				'username'  => $result->user_name,
				'email'     => $result->email,
				'logged_in' => TRUE
			);
			$this->session->set_userdata($newdata);
			redirect(ROUTES::USER_DASHBOARD);
		}
		else {
			$this->session->set_flashdata('error', 'Incorrect username or password.');
			$this->load->view('login');
		}
	}

	public function userLogOut() {
		//print_r('dsdf');
		//die();
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('logged_in');
		$this->load->view('login');
		//print_r($_SESSION);
		//die();
	}

	public function userHome() {
		$this->load->view('home');
	}

	public function isUniqueUsernameAJAX() {
		$username = $this->input->post('usernameReg');
		$result = $this->User_Model->isUniqueUsernameAJAX($username);
		echo json_encode($result);
	}
}
