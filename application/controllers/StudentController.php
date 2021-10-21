<?php

class StudentController extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Student');
    }

    public function index(){
        $data['title']      = 'Survey Gigi - Student';
        $data['navActive']  = 'student';

        $this->template->view('student/student', $data);
    }
}