<?php
    class User extends CI_Model{
        public function getAll(){
            return $this->db->get('user')->result();
        }
        // public function get($id_berita){
        //     return $this->db->where('id_berita', $id_berita)->get('berita')->row();
        // }
        public function insert($param){
            return $this->db->insert('user', $param);
        }
        public function checkUser($param) {		
            return $this->db->get_where('user', $param)->row();
        }	
        // public function update($param){
        //     $this->db->where('id_berita', $param['id_berita'])->update('berita', $param);
        // }
        // public function delete($id_berita){
        //     $this->db->where('id_berita', $id_berita)->delete('berita');
        // }
    }
