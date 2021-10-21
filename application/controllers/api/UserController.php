<?php
    use chriskacerguis\RestServer\RestController;
    class UserController extends RestController {
        public function __construct() {
            parent::__construct();
            $this->load->model('User');
            $this->load->model('Report');
        }
        public function index_get(){
            $result = $this->User->getAll();
            $this->response([
                'status' => true, 
                'message' => 'Data matched!', 
                'data' => $result
            ], 200);
        }
        public function register_post() {
            $arr = array(
                'email' => $this->post('email'),
                'name' => $this->post('name'),
                'gender' => $this->post('gender'),
                'birth_date' => date_format(date_create($this->post('birth_date')), "Y-m-d"),
                'phone_number' => $this->post('phone_number'),
                'school_name' => $this->post('school_name'),
                'school_class' => $this->post('school_class'),
                'password' => md5($this->post('password'))
            );
            $result = $this->User->insertUser($arr);
            if ($result) {
                $this->response(['status' => true, 'message' => 'Register successfully'], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Register failed, email is already exists'], 200);     
            }
        }
        public function login_post() {
            $email = $this->post('email');
            $password = md5($this->post('password'));

            $arr = array(
                'email' => $email,
                'password' => $password
            );
            
            $data['user'] = $this->User->checkUser($arr);
            if ($data['user']) {
                $arrReport = array(
                    'user_email' => $email
                );
                if ($this->Report->checkUserReport($arrReport)) {
                    $insert = array(
                        'user_email' => $email,
                        'status' => 'ongoing'
                    );
                    $this->Report->insertReport($insert);
                }
                $data['report'] = $this->Report->getReport($arrReport);
            }
            if ($data['user']) {
                $this->response([
                    'status' => true, 
                    'message' => 'Login successfully',
                    'data' => $data], 200);
            } else {
                $this->response(['status' => false, 'message' => 'Login failed, email or password is incorrect'], 200);
            }
        }
        public function forgotPassword_post() {
            $email = $this->post('email');
            $password = md5($this->post('password'));
            $newpassword = md5($this->post('newpassword'));
            
            $arr = array(
                'email' => $email,
                'password' => $password,
                'newpassword' => $newpassword
            );
            $result = $this->User->forgotPassword($arr);
            if ($result == 2) {
                $this->response(['status' => true, 'message' => 'Password reset successfully'], 200);
            } else if ($result == 0){
                $this->response(['status' => false, 'message' => "Old Password doesn't match"], 200);     
            } else if ($result == 1) {
                $this->response(['status' => false, 'message' => "Email doesn't match"], 200);
            }
        }
    }