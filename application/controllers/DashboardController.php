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
        $data['title']                  = 'Survey Gigi - Dashboard';
        $data['navActive']              = 'dashboard';

        $data['users']                  = $this->Dashboard->getUsers();
        $data['activeReports']          = $this->Dashboard->getActiveReports();
        $data['finishedReports']        = $this->Dashboard->getFinishedReports();
        $data['canceledReports']        = $this->Dashboard->getCanceledReports();
        
        $this->template->view('dashboard', $data);
    }
}