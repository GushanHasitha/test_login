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
		$password = $this->input->post('password');
		$password = password_hash($password, PASSWORD_DEFAULT);

		//print_r($password);
		//die();

		$out = "";

		try{
			$out = "{\"ret\":\"success\", \"message\":\"You are successfully Registered\"}";
			$this->User_Model->userRegister($username, $email, $password);		
		}
		catch (Exception $exception)
		{	
			//print_r('dsfs');
			//die();
			$out = "{\"ret\":\"failed\", \"message\":\"" . $exception->getMessage() . "\"}";
		}

		echo $out;
	}

	public function userLogin() {
		try {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			//print_r($password);
			//die();

			$result = $this->User_Model->userLogin($username, $password);
			
			//print_r($result);
			//die();
			if(isset($result)) {
				$newdata = array(
					'username'  => $result->user_name,
					'email'     => $result->email,
					'logged_in' => TRUE
				);
				$this->session->set_userdata($newdata);
				//print_r($_SESSION);
				//die();
				redirect(ROUTES::USER_DASHBOARD);
			}
			else {
				$data['error'] = 'Incorrect username or password.';
				$this->load->view('login', $data);
			}
		
		}
		catch(Exception $e) {
			$data['error'] = $e->getMessage();
			$this->load->view('login', $data);
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
