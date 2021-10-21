<?php

class StudentController extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Student');
        if (empty($this->session->userdata('user_logged'))) {
			redirect();
		};
    }

    public function index(){
        $data['title']      = 'Survey Gigi - Student';
        $data['navActive']  = 'student';

        $this->template->view('student/student', $data);
    }
}