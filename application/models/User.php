<?php
    class User extends CI_Model{
        public function getAll(){
            return $this->db->get('user')->result();
        }
        public function insertUser($param){
            $this->db->insert('user', $param);
        }
        public function checkUser($param) {		
            $this->db->select('email, name, gender, birth_date, phone_number, school_name, school_class');
            return $this->db->get_where('user', $param)->row();
        }	
    }
