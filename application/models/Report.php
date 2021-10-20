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
            $this->db->select('count(*) as entry, r.day as day');
            $this->db->from('user u');
            $this->db->join('report r', 'r.user_email = u.email', 'left');
            $this->db->join('report_detail rd', 'rd.report_id = r.report_id', 'left');
            $this->db->where('u.email', $param);
            $this->db->where('DATE(rd.created_at) >=', date('Y-m-d', strtotime('yesterday')));
            $this->db->where('DATE(rd.created_at) <=', date('Y-m-d'));
            $this->db->order_by('rd.created_at DESC');
            return $this->db->get()->row();
        }
        public function changeDayReport($param, $data) {
            $this->db->where('user_email', $param)->update('report', $data);
        }
        public function getReport($param) {
            $this->db->select('report_id, day, status');
            return $this->db->get_where('report', $param)->row();
        }
        public function addReport($param) {
            $this->db->insert('report_detail', $param);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
    }
