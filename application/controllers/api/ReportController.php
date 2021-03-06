<?php
    use chriskacerguis\RestServer\RestController;
    class ReportController extends RestController {
        public function __construct() {
            parent::__construct();
            $this->load->model('Report');
        }
        // Dashboard aplikasi
        public function report_post() {
            $nisn = $this->post('nisn');
            $last_open = $this->Report->checkLastOpen($nisn);
            if ($last_open == null) {
                $this->checkReport($nisn, null, null);
            } else {
                $today = date("Y-m-d h:i:s");
                $arr = array(
                    'last_open' => $today
                );
                $this->Report->changeLastOpen($last_open->report_id, $arr);
                if ($last_open->date != date("Y-m-d") || $last_open->day == 21) {
                    if ($last_open->status != 'finished') {
                        $this->checkReport($nisn, $last_open->report_id, $last_open->day);
                    }
                } 
            }
            $current_time = date("H");
            if ($current_time < 17) {
                $time = 'day';
            } else {
                $time = 'night';
            }
            $arr = array(
                'r.user_nisn' => $nisn,
                'r.status !=' => 'canceled'
            );
            $temp = $this->Report->getDailyReport($arr);
            $day21 = $this->Report->get21DayReport($arr);
            if ($temp->report_id == null && $day21->day == 21 && $day21->status == 'finished') {
                $report = array(
                    'report_id' => $day21->report_id,
                    "entry" => $day21->entry,
                    "time" => $time,
                    "day" => $day21->day,
                    "status" => $day21->status
                );
            } else if ($temp->report_id == null) {
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
            if ($data['report']) {
                $this->response([
                    'status' => true, 
                    'message' => 'Get Report berhasil',
                    'data' => $data], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Get Report gagal'], 200);
            }
        }
        public function checkReport($nisn, $report_id, $day) {
            $arr = array(
                'r.user_nisn' => $nisn,
                'r.status !=' => 'canceled'
            );
            $temp = $this->Report->getYesterdayReport($arr);
            if ($temp->day == 21) {
                $arr = array(
                    'r.user_nisn' => $nisn
                );
                $tempToday = $this->Report->getDailyReport($arr);
                if ($tempToday->entry >= 4) {
                    $update = array(
                        'status' => 'finished'
                    );
                    $this->Report->updateStatusReport($report_id, $update);
                } 
            } else if ($temp->day < 21 && $temp->report_id != null) {
                $update = array(
                    'day' => $temp->day + 1
                );
                $this->Report->updateStatusReport($report_id, $update);
            }
        }
        public function reportAdd_post() {
            date_default_timezone_set("Asia/Jakarta");
            $current_time = date("H");            
            if ($current_time >= 5 && $current_time <= 8 || $current_time >= 17 && $current_time <= 24) {
                $report_id = $this->post('report_id');
                $category = $this->post('category');
                $status = $this->post('status');
                $image = $this->upload_image($report_id, $category, $status);
                $arr = array(
                    'report_id' => $report_id,
                    'image' => $image,
                    'category' => $category,
                    'status' => $status,
                    'created_at' => date("Y-m-d H:i:s")
                );
                $result = $this->Report->addReport($arr);
                if ($result) {
                    $this->response([
                        'status' => true, 
                        'message' => 'Tambah Report berhasil'], 200);
                } else {
                    $this->response(['status' => false, 'message' => 'Tambah Report gagal'], 200);
                }
            } else {
                $this->response(['status' => false, 'message' => 'some thing wrong'], 200);
                if ($current_time < 17) {
                    $this->response(['status' => false, 'message' => 'waktu upload pagi pukul 5:00 sampai 8:00 WIB'], 200);
                } else {
                    $this->response(['status' => false, 'message' => 'waktu upload malam pukul 17:00 sampai 23:59 WIB'], 200);
                }
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
    
                    return base_url('/assets/uploads/images/'.$id.'/'.$fileimage);
                }
                          
            }
        }
    }
