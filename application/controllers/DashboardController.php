<?php

class DashboardController extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Dashboard');
        if (empty($this->session->userdata('user_logged'))) {
			redirect();
		};
    }

    public function index(){
        $data['title']                  = 'BMTC - Dashboard';
        $data['navActive']              = 'dashboard';

        $data['users']                  = $this->Dashboard->getUsers();
        $data['ongoingReports']         = $this->Dashboard->getOngoingReports();
        $data['finishedReports']        = $this->Dashboard->getFinishedReports();
        $data['canceledReports']        = $this->Dashboard->getCanceledReports();

        $data['thisMonthReportTotal']   = $this->Dashboard->getThisMonthReports();
        $data['thisMonthReportChart']   = $this->Dashboard->getThisMonthReportsChart();
        $data['thisYearReportTotal']    = $this->Dashboard->getThisYearReports();
        $data['thisYearReportChart']    = $this->Dashboard->getThisYearReportsChart();

        $data['todayReports']           = $this->Dashboard->getTodayReports();
        $data['avgCanceledReports']     = $this->Dashboard->getAvgCanceledReports();
        $data['avgCanceledReportsChart']     = $this->Dashboard->getAvgCanceledReportsChart();
        
        // print_r($data['todayReports']);
        $this->template->view('dashboard', $data);
    }
}