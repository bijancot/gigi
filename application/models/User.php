<?php
    class User extends CI_Model{
        public function getAll(){
            return $this->db->get('user')->result();
        }
        public function insertUser($param){
            $this->db->where('nisn', $param['nisn']);
            $this->db->from('user');
            $count = $this->db->count_all_results();

            if($count == 0) {
                $this->db->insert('user', $param);
                return true;
            } else {
                return false;
            }
        }
        public function checkUser($param) {		
            $this->db->select('nisn, name, gender, DATE_FORMAT(birth_date, "%d %M %Y") as birth_date, phone_number, school_class');
            return $this->db->get_where('user', $param)->row();
        }	
        public function forgotPassword($param) {
            $this->db->where('nisn', $param['nisn']);
            $count = $this->db->get('user')->num_rows();

            if($count > 0) {
                $this->db->where('nisn', $param['nisn']);
                $this->db->where('password', $param['password']);
                $count_pass = $this->db->get('user')->num_rows();
                if ($count_pass > 0) {
                    $this->db->where('nisn', $param['nisn']);
                    $this->db->where('password', $param['password']);
                    $data = array(
                        'password' => $param['newpassword']
                    );      
                    $this->db->update('user', $data);
                    return 2;
                } else {
                    return 0;
                }
            } else {
                return 1;
            }
        }
        public function updatePassword($param, $data) {
            $this->db->where('nisn', $param)->update('user', $data);
        }
        public function updateUser($param, $data){
            $this->db->where('nisn', $param);
            $this->db->from('user');
            $count = $this->db->count_all_results();

            if($count != 0) {
                $this->db->where('nisn', $param);
                $this->db->update('user', $data);
                return true;
            } else {
                return false;
            }
        }
    }
