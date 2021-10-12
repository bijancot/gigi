<?php
    use chriskacerguis\RestServer\RestController;
    class UserController extends RestController {
        public function __construct() {
            parent::__construct();
            $this->load->model('User');
        }
        public function index_get(){
            $result = $this->User->getAll();
            $this->response([
                'status' => true, 
                'message' => 'Data matched!', 
                'data' => $result
            ], 200);
        }
        public function index_post() {
            $param = $_POST;
            if ($param['type'] == 'login') {
                $email = $this->post('email');
                $password = md5($this->post('password'));
    
                $arr = array(
                    'email' => $email,
                    'password' => $password
                );
                $result = $this->User->checkUser($arr);
                if ($result) {
                    $this->response(['status' => true, 'message' => 'Login successfully'], 200);
                } else {
                    $this->response(['status' => false, 'message' => 'Login failed'], 404);
                }
            } else if ($param['type'] == 'register') {
                $email = $this->post('email');
                $name = $this->post('name');
                $gender = $this->post('gender');
                $birth_date = date_format(date_create($this->post('birth_date')), "Y-m-d");
                $phone_number = $this->post('phone_number');
                $school_name = $this->post('school_name');
                $school_class = $this->post('school_class');
                $password = md5($this->post('password'));
    
                $arr = array(
                    'email' => $email,
                    'name' => $name,
                    'gender' => $gender,
                    'birth_date' => $birth_date,
                    'phone_number' => $phone_number,
                    'school_name' => $school_name,
                    'school_class' => $school_class,
                    'password' => $password
                );
                $result = $this->User->insert($arr);
                if ($result) {
                    $this->response(['status' => true, 'message' => 'Register successfully'], 200);
                } else {
                    $this->response(['status' => false, 'message' => 'Register failed'], 404);
                }        
            }
        }
    }