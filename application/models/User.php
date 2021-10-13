<?php
    class User extends CI_Model{
        public function getAll(){
            return $this->db->get('user')->result();
        }
        public function insertUser($param){
            $this->db->where('email', $param['email']);
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
            $this->db->select('email, name, gender, birth_date, phone_number, school_name, school_class');
            return $this->db->get_where('user', $param)->row();
        }	
        public function forgotPassword($param) {
            $this->db->where('email', $param['email']);
            $this->db->where('password', $param['password']);
            $count = $this->db->get('user')->num_rows();

            if($count > 0) {
                $this->db->where('email', $param['email']);
                $this->db->where('password', $param['password']);
                $data = array(
                    'password' => $param['newpassword']
                );      
                $this->db->update('user', $data);
                return true;
            } else {
                return false;
            }
        }
    }
