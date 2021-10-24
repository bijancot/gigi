<?php

class Dashboard extends CI_Model {
    public function getUsers() {
        $this->db->select("count(*) as total");
        return $this->db->from('user')->get()->row();
    }
    public function getOngoingReports() {
        $this->db->select("count(*) as total");
        $this->db->where('status', 'ongoing');
        return $this->db->from('report')->get()->row();
    }
    public function getFinishedReports() {
        $this->db->select("count(*) as total");
        $this->db->where('status', 'finished');
        return $this->db->from('report')->get()->row();
    }
    public function getCanceledReports() {
        $this->db->select("count(*) as total");
        $this->db->where('status', 'canceled');
        return $this->db->from('report')->get()->row();
    }
    public function getThisMonthReports() {
        $this->db->select("count(*) as total");
        $this->db->where('MONTH(created_at) = MONTH(CURRENT_DATE)');
        return $this->db->from('report_detail')->get()->row();
    }
    public function getTodayReports() {
        $this->db->select("u.name, r.day, rd.category");
        $this->db->from('user u');
        $this->db->join('report r', 'r.user_email = u.email', 'left');
        $this->db->join('report_detail rd', 'rd.report_id = r.report_id', 'left');
        $this->db->where('DATE(rd.created_at)', date('Y-m-d'));
        $this->db->group_by('rd.category');
        $this->db->limit(6);
        return $this->db->get()->result();
    }
}