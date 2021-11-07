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
                if ($last_open->date != date("Y-m-d") || $last_open->day == 21) {
                    $today = date("Y-m-d h:i:s");
                    $arr = array(
                        'last_open' => $today
                    );
                    $this->Report->changeLastOpen($last_open->report_id, $arr);
                    if ($last_open->status != 'finished') {
                        $this->checkReport($nisn, $last_open->report_id, $last_open->day);
                    }
                } 
            }
            $arr = array(
                'r.user_nisn' => $nisn,
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
                    'message' => 'Get Report berhasil',
                    'data' => $data], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Get Report gagal'], 200);
            }
        }
        public function checkReport($nisn, $report_id, $day) {
            $temp = $this->Report->getYesterdayReport($nisn);
            if ($temp->entry < 4) {
                if ($day != 1) {
                    if ($report_id != null) {
                        $update = array(
                            // 'day' => 1,
                            'status' => 'canceled'
                        );
                        $this->Report->updateStatusReport($report_id, $update);
                    }
                    $insert = array(
                        'user_nisn' => $nisn,
                        'status' => 'ongoing'
                    );
                    $this->Report->insertReport($insert);
                }
            } else {
                if ($temp->day == 21) {
                    $arr = array(
                        'r.user_nisn' => $nisn
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
        public function reportAdd_post() {
            $current_time = date("H");
            if ($current_time >= 5 && $current_time <= 8 || $current_time >= 17 && $current_time <= 21) {
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
                        'message' => 'Tambah Report berhasil'], 200);
                } else {
                    $this->response(['status' => false, 'message' => 'Tambah Report gagal'], 200);
                }
            } else {
                if ($current_time < 17) {
                    $this->response(['status' => false, 'message' => 'waktu upload pagi pukul 5:00 sampai 8:00 WIB'], 200);
                } else {
                    $this->response(['status' => false, 'message' => 'waktu upload malam pukul 17:00 sampai 21:00 WIB'], 200);
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