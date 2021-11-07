<?php

class Admin extends CI_Model{
    private $_table = "admin";
    public function register($data){      
        // Insert user
        return $this->db->insert($this->_table, $data);
    }

    function login($username, $password) {		
		$where = array(
            'username' => $username,
            'password' => $password
            );
            $query = $this->db->get_where($this->_table, $where);
            if($query) {
                return $query->row();
            }
        return false;
	}	
}