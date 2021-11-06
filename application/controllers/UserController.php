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
        $data['title']      = 'BMTC - User';
        $data['navActive']  = 'user';
        $data['users'] = $this->User->getAll();

        $this->template->view('user/user', $data);
    }
    public function resetPassword() {
        $nisn = $this->input->post('nisn');
        $data = array(
            'password' => md5('password_baru_'.$nisn)
        );
        $this->User->updatePassword($nisn, $data);
        redirect('user');
    }
}