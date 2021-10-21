<?php

class UserController extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('User');
        if (empty($this->session->userdata('user_logged'))) {
			redirect();
		};
    }

    public function index(){
        $data['title']      = 'Survey Gigi - User';
        $data['navActive']  = 'user';

        $this->template->view('user/user', $data);
    }
}