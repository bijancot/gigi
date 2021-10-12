<?php
    use chriskacerguis\RestServer\RestController;
    class ReportController extends RestController {
        public function __construct() {
            parent::__construct();
            $this->load->model('Report');
        }
        public function report_post() {
            $email = $this->post('email');
            $arr = array(
                'user_email' => $email
            );
            $data['report'] = $this->Report->checkReport($arr);
            if ($data['report']) {
                $this->response([
                    'status' => true, 
                    'message' => 'Report successfully',
                    'data' => $data], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Report failed'], 404);
            }
        }
        public function reportAdd_post() {
            $report_id = $this->post('report_id');
            $image = $this->post('image');
            $category = $this->post('category');
            $status = $this->post('status');
            $arr = array(
                'report_id' => $report_id,
                'image' => $image,
                'category' => $category,
                'status' => $status,
            );
            $result = $this->Report->addReport($arr);
            if ($result) {
                $this->response([
                    'status' => true, 
                    'message' => 'Report add successfully'], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Report add failed'], 404);
            }
        }
    }