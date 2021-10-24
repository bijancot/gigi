<?php

class ReportController extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Report');
        if (empty($this->session->userdata('user_logged'))) {
			redirect();
		};
    }

    public function index(){
        $data['title']      = 'Survey Gigi - Report';
        $data['navActive']  = 'ongoing-report';
        $data['reports']    = $this->Report->getAll();

        $this->template->view('report/report', $data);
    }
    public function finished(){
        $data['title']      = 'Survey Gigi - Report';
        $data['navActive']  = 'finished-report';
        $data['reports']    = $this->Report->getAllFinished();

        $this->template->view('report/finishedreport', $data);
    }
    public function canceled(){
        $data['title']      = 'Survey Gigi - Report';
        $data['navActive']  = 'canceled-report';
        $data['reports']    = $this->Report->getAllCanceled();

        $this->template->view('report/canceledreport', $data);
    }
    public function changeStatus(){
        $param = array(
            'report_id' => $this->input->post('report_id'),
            'status' => 'canceled'
        );
        $this->Report->update($param);
        $this->session->set_flashdata('succ', 'Successfully changed the status on the student ', 1);
        redirect('report');
    }
    public function detailReport($report_id){
        $data['title']      = 'Survey Gigi - Detail Report';
        $data['navActive']  = 'detail-report';
        $data['reports']    = $this->Report->getID($report_id);

        // print_r($data['reports'])
        $this->template->view('report/detailreport', $data);
    }
}