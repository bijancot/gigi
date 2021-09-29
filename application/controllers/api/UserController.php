<?php
    use chriskacerguis\RestServer\RestController;
    class UserController extends RestController {
        public function __construct() {
            parent::__construct();
            $this->load->model('User');
        }
        public function index_get(){
            $berita = $this->User->getAll();
            $this->response([
                'status' => true, 
                'message' => 'Data matched!', 
                'data' => $berita
            ], 200);
        }
        public function index_post() {
            $email = $this->post('email');
            $name = $this->post('name');
            $gender = $this->post('gender');
            $birth_date = $this->post('birth_date');
            $phone_number = $this->post('phone_number');
            $school_name = $this->post('school_name');
            $school_class = $this->post('school_class');
            $password = $this->post('password');

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
            $this->User->insert($arr);
            $this->response(['status' => true, 'message' => 'Data berhasill ditambahkan'], 200);
        }
    }