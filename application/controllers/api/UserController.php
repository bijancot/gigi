<?php
    use chriskacerguis\RestServer\RestController;
    class UserController extends RestController {
        public function __construct() {
            parent::__construct();
            $this->load->model('User');
            $this->load->model('Report');
        }
        public function register_post() {
            $arr = array(
                'nisn' => $this->post('nisn'),
                'name' => $this->post('name'),
                'gender' => $this->post('gender'),
                'birth_date' => date_format(date_create($this->post('birth_date')), "Y-m-d"),
                'phone_number' => $this->post('phone_number'),
                'school_class' => $this->post('school_class'),
                'password' => md5($this->post('password'))
            );
            $result = $this->User->insertUser($arr);
            if ($result) {
                $this->response(['status' => true, 'message' => 'Register berhasil'], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Register gagal, NISN sudah ada'], 200);     
            }
        }
        public function login_post() {
            $nisn = $this->post('nisn');
            $password = md5($this->post('password'));

            $arr = array(
                'nisn' => $nisn,
                'password' => $password
            );
            
            $data['user'] = $this->User->checkUser($arr);
            if ($data['user']) {
                $arrReport = array(
                    'user_nisn' => $nisn,
                    'status !=' => 'canceled'
                );
                if ($this->Report->checkUserReport($arrReport)) {
                    $insert = array(
                        'user_nisn' => $nisn,
                        'status' => 'ongoing'
                    );
                    $this->Report->insertReport($insert);
                }
                // $data['report'] = $this->Report->getReport($arrReport);
            }
            if ($data['user']) {
                $this->response([
                    'status' => true, 
                    'message' => 'Login berhasil',
                    'data' => $data], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Login gagal, NISN atau password salah'], 200);
            }
        }
        public function forgotPassword_post() {
            $nisn = $this->post('nisn');
            $password = md5($this->post('password'));
            $newpassword = md5($this->post('newpassword'));
            
            $arr = array(
                'nisn' => $nisn,
                'password' => $password,
                'newpassword' => $newpassword
            );
            $result = $this->User->forgotPassword($arr);
            if ($result == 2) {
                $this->response(['status' => true, 'message' => 'Password reset berhasil'], 200);
            } else if ($result == 0){
                $this->response(['status' => false, 'message' => "Password lama tidak cocok"], 200);     
            } else if ($result == 1) {
                $this->response(['status' => false, 'message' => "NISN tidak cocok"], 200);
            }
        }
    }