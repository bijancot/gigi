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
                $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]', array(
                    'is_unique' => '%s already exists.'
                ));
                $this->form_validation->set_rules('name','Name','trim|required');
                $this->form_validation->set_rules('gender','Gender','trim|required');
                $this->form_validation->set_rules('birth_date','Birth Date','trim|required');
                $this->form_validation->set_rules('phone_number','Phone Number','trim|required');
                $this->form_validation->set_rules('school_name','School Name','trim|required');
                $this->form_validation->set_rules('school_class','School Class','trim|required');
                $this->form_validation->set_rules('password', 'Password', 'required');

                if($this->form_validation->run() == TRUE) {
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
                    $this->User->insert($arr);
                    $this->response(['status' => true, 'message' => 'Register successfully'], 200);
                } else {
                    $this->response(['status' => false, 'message' => 'Register failed, '.validation_errors()], 404);
                }                
            }
        }
    }