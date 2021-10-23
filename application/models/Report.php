<?php
    class Report extends CI_Model{
        public function getID($param){
            $this->db->select('rd.detreport_id as dreport_id, rd.report_id as report_id, u.name as name, rd.image as image, rd.category as category, rd.status as status, rd.created_at as created_at, r.status as progress');
            $this->db->from('user u');
            $this->db->join('report r', 'r.user_email = u.email', 'left');
            $this->db->join('report_detail rd', 'rd.report_id = r.report_id', 'left');
            $this->db->where('rd.report_id', $param);
            return $this->db->get()->result();
        }
        public function getAll(){
            $this->db->select('r.report_id as report_id, u.email as email, u.name as name, r.day as day, r.status as status, max(rd.created_at) as created_at');
            $this->db->from('user u');
            $this->db->join('report r', 'r.user_email = u.email');
            $this->db->join('report_detail rd', 'rd.report_id = r.report_id', 'left');
            $this->db->where('r.status !=', 'canceled');
            $this->db->group_by('r.report_id');
            return $this->db->get()->result();
        }
        public function getAllCanceled(){
            $this->db->select('r.report_id as report_id, u.email as email, u.name as name, r.day as day, r.status as status, max(rd.created_at) as created_at');
            $this->db->from('user u');
            $this->db->join('report r', 'r.user_email = u.email');
            $this->db->join('report_detail rd', 'rd.report_id = r.report_id', 'left');
            $this->db->where('r.status', 'canceled');
            $this->db->group_by('r.report_id');
            return $this->db->get()->result();
        }
        public function update($param){
            $this->db->where('report_id', $param['report_id'])->update('report', $param);
        }
        // API User
        public function insertReport($param) {
            $this->db->insert('report', $param);
        }
        public function checkUserReport($param) {
            $query = $this->db->get_where('report', $param)->num_rows();
            return ($query > 0) ? FALSE : TRUE;
        }
        // API Report
        public function checkLastOpen($param) {
            $this->db->select('r.report_id as report_id, DATE(r.last_open) as date');
            $this->db->from('report r');
            $this->db->join('user u', 'u.email = r.user_email', 'left');
            $this->db->where('u.email', $param);
            $this->db->where('r.status !=', 'canceled');
            return $this->db->get()->row();
        }
        public function changeLastOpen($param, $data) {
            $this->db->where('report_id', $param)->update('report', $data);
        }
        public function getDailyReport($param) {
            $this->db->select('count(rd.created_at) as entry, r.report_id as report_id, r.day as day, r.status as status');
            $this->db->from('report r');
            $this->db->join('report_detail rd', 'rd.report_id = r.report_id', 'left');
            $this->db->where($param);
            $this->db->where('DATE(rd.created_at)', date('Y-m-d'));
            return $this->db->get()->row();
        }
        public function getFirstTimeReport($param) {
            $this->db->select('r.report_id as report_id, r.day as day, r.status as status');
            $this->db->from('report r');
            $this->db->join('report_detail rd', 'rd.report_id = r.report_id', 'left');
            $this->db->where($param);
            return $this->db->get()->row();
        }
        public function getYesterdayReport($param) {
            $this->db->select('count(rd.created_at) as entry, r.report_id as report_id, r.day as day, r.status as status');
            $this->db->from('report r');
            $this->db->join('report_detail rd', 'rd.report_id = r.report_id', 'left');
            $this->db->where('r.user_email', $param);
            $this->db->where('DATE(rd.created_at)', date('Y-m-d', strtotime('yesterday')));
            return $this->db->get()->row();
        }
        public function updateStatusReport($param, $data) {
            $this->db->where('report_id', $param)->update('report', $data);
        }
        // Old
        public function checkReport($param) {
            $this->db->select('count(*) as entry, r.day as day, r.status as status, r.report_id as report_id');
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
            $this->db->where('report_id', $param)->update('report', $data);
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
