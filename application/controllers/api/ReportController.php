<?php
    use chriskacerguis\RestServer\RestController;
    class ReportController extends RestController {
        public function __construct() {
            parent::__construct();
            $this->load->model('Report');
        }
        // Dashboard aplikasi
        public function report_post() {
            $email = $this->post('email');
            $last_open = $this->Report->checkLastOpen($email);
            if ($last_open == null) {
                $this->checkReport($email, null);
            } else {
                if ($last_open->date != date("Y-m-d")) {
                    $today = date("Y-m-d h:i:s");
                    $arr = array(
                        'last_open' => $today
                    );
                    $this->Report->changeLastOpen($last_open->report_id, $arr);
                } 
                $this->checkReport($email, $last_open->report_id);
            }
            $arr = array(
                'r.user_email' => $email,
                'r.status !=' => 'canceled'
            );
            $temp = $this->Report->getDailyReport($arr);
            $current_time = date("H");
            if ($current_time < 17) {
                $time = 'day';
            } else {
                $time = 'night';
            }
            if ($temp->report_id == null) {
                $first_time = $this->Report->getFirstTimeReport($arr);
                $report = array(
                    'report_id' => $first_time->report_id,
                    "entry" => $temp->entry,
                    "time" => $time,
                    "day" => $first_time->day,
                    "status" => $first_time->status
                );
            } else {
                $report = array(
                    'report_id' => $temp->report_id,
                    "entry" => $temp->entry,
                    "time" => $time,
                    "day" => $temp->day,
                    "status" => $temp->status
                );
            }
            $data['report'] = $report;
            // $data['report'] = $this->Report->getReport($arr);
            if ($data['report']) {
                $this->response([
                    'status' => true, 
                    'message' => 'Get Report successfully',
                    'data' => $data], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Get Report failed'], 200);
            }
        }
        public function checkReport($email, $report_id) {
            $temp = $this->Report->getYesterdayReport($email);
            if ($temp->entry < 4) {
                $update = array(
                    'day' => 1,
                    'status' => 'canceled'
                );
                $this->Report->updateStatusReport($report_id, $update);
                $insert = array(
                    'user_email' => $email,
                    'status' => 'ongoing'
                );
                $this->Report->insertReport($insert);
            } else {
                if ($temp->day == 21) {
                    $arr = array(
                        'r.user_email' => $email
                    );
                    $tempToday = $this->Report->getDailyReport($arr);
                    if ($tempToday->entry < 4) {
                        $update = array(
                            'status' => 'ongoing'
                        );
                    } else {
                        $update = array(
                            'status' => 'finished'
                        );
                    }
                    $this->Report->updateStatusReport($report_id, $update);
                } else if ($temp->day < 21) {
                    $update = array(
                        'day' => $temp->day + 1,
                        'status' => 'ongoing'
                    );
                    $this->Report->updateStatusReport($report_id, $update);
                }
            }
        }
        // // Check hari
        // public function checkReport_post() {
        //     $email = $this->post('email');
        //     $temp = $this->Report->checkReport($email);
        //     // if ($temp->entry == 4) {
        //     //     $day = array(
        //     //         'day' => $temp->day + 1
        //     //     );
        //     // } else {
        //     //     $day = array(
        //     //         'day' => 1
        //     //     );
        //     // }
        //     if ($temp->entry != 4) {
        //         $day = array(
        //             'day' => 1
        //         );
        //     } else {
        //         $day = array(
        //             'day' => $temp->day + 1
        //         );
        //     }
        //     if ($temp->status == 'canceled') {
        //         $insert = array(
        //             'user_email' => $email,
        //             'status' => 'ongoing'
        //         );
        //         $this->Report->insertReport($insert);
        //     }
        //     $this->Report->changeDayReport($temp->report_id, $day);
        // }
        public function reportAdd_post() {
            $report_id = $this->post('report_id');
            $category = $this->post('category');
            $status = $this->post('status');
            $image = $this->upload_image($report_id, $category, $status);
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
        function upload_image($id, $category, $status){
            $this->load->library('upload');
            $newPath = './assets/uploads/images/'.$id.'/';
            $new_name = date('Y_m_d').'-'.$category.'-'.$status;
            if(!is_dir($newPath)){
                mkdir($newPath, 0777, TRUE);
            }
            $config['upload_path'] = $newPath;
            $config['allowed_types'] = 'png|jpg|jpeg'; 
            $config['encrypt_name'] = FALSE;
            $config['file_name'] = $new_name;
            
            $this->upload->initialize($config);
            if(!empty($_FILES['image']['name'])){
     
                if ($this->upload->do_upload('image')){
                    $image = $this->upload->data(); 
                    $fileimage = $image['file_name'];
    
                    return '/assets/uploads/images/'.$id.'/'.$fileimage;
                }
                          
            }
        }
    }