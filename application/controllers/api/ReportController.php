<?php
    use chriskacerguis\RestServer\RestController;
    class ReportController extends RestController {
        public function __construct() {
            parent::__construct();
            $this->load->model('Report');
        }
        public function checkReport_post() {
            $email = $this->post('email');
            $temp = $this->Report->checkReport($email);
            // if ($temp->entry == 4) {
            //     $day = array(
            //         'day' => $temp->day + 1
            //     );
            // } else {
            //     $day = array(
            //         'day' => 1
            //     );
            // }
            if ($temp->entry != 4) {
                $day = array(
                    'day' => 1
                );
            } else {
                $day = array(
                    'day' => $temp->day + 1
                );
            }
            if ($temp->status == 'canceled') {
                $insert = array(
                    'user_email' => $email,
                    'status' => 'ongoing'
                );
                $this->Report->insertReport($insert);
            }
            $this->Report->changeDayReport($email, $day);
            $this->report_post();
        }
        public function report_post() {
            $email = $this->post('email');
            $arr = array(
                'user_email' => $email,
                'status !=' => 'canceled'
            );
            $data['report'] = $this->Report->getReport($arr);
            if ($data['report']) {
                $this->response([
                    'status' => true, 
                    'message' => 'Get Report successfully',
                    'data' => $data], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Get Report failed'], 200);
            }
        }
        public function reportAdd_post() {
            $report_id = $this->post('report_id');
            $image = $this->upload_pdf($report_id);
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
                    'message' => 'Add Report successfully'], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Add Report failed'], 200);
            }
        }
        function upload_pdf($id){
            $this->load->library('upload');
            $newPath = './assets/uploads/images/'.$id.'/';
            if(!is_dir($newPath)){
                mkdir($newPath, 0777, TRUE);
            }
            $config['upload_path'] = $newPath;
            $config['allowed_types'] = 'png|jpg'; 
            $config['encrypt_name'] = FALSE;
     
            $this->upload->initialize($config);
            if(!empty($_FILES['image']['name'])){
     
                if ($this->upload->do_upload('image')){
                    $image = $this->upload->data(); 
                    $fileimage = $image['file_name'];
    
                    return base_url('/assets/uploads/images/'.$id.'/'.$fileimage);
                }
                          
            }
        }
    }