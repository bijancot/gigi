<?php

class ReportController extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Report');
    }

    public function index(){
        $data['title']      = 'Survey Gigi - Report';
        $data['navActive']  = 'report';

        $this->template->view('report/report', $data);
    }
}