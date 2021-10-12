<?php
    class Report extends CI_Model{
        public function insertReport($param) {
            $this->db->insert('report', $param);
        }
        public function checkUserReport($param) {
            $query = $this->db->get_where('report', $param)->num_rows();
            return ($query > 0) ? FALSE : TRUE;
        }
        public function checkReport($param) {
            $this->db->select('report_id, day, status');
            return $this->db->get_where('report', $param)->row();
        }
        public function addReport($param) {
            return $this->db->insert('report_detail', $param);
        }
    }
