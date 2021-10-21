<?php

class AuthController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Admin');
    }
    public function index() {
        if ($this->session->userdata('user_logged')) {
            redirect('dashboard');
        } else {
            $this->load->view('auth/login');
        }
    }
    public function login() {
        $this->form_validation->set_rules('email','Email','required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run() == TRUE) {
            $email = $this->input->post('email');
            $password = md5($this->input->post('password'));
            $user = $this->Admin->login($email, $password);
            if($user != false ){
                $sessionData = array(
                    'email'         => $user->email,
                    'name'          => $user->name,
                    'user_logged'   => TRUE
                );
                $this->session->set_userdata($sessionData);
                $this->session->set_tempdata('auth_msg', 'Login Successfully', 3);
                redirect('dashboard');
            } else {
                $this->session->set_tempdata('auth_msg', 'Login Failed, Email or Password is incorrect!', 3);
                redirect();
            }
        } else {
            //Create Message
            $this->session->set_tempdata('auth_msg', validation_errors(), 3);
            redirect();
        }
    }
    public function logout() {
        $this->session->sess_destroy();
        redirect();
    }
}
