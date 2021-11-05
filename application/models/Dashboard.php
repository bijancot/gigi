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
    public function getThisMonthReportsChart() {
        $this->db->select("day(created_at) as day, count(*) total");
        $this->db->where('MONTH(created_at) = MONTH(CURRENT_DATE)');
        $this->db->group_by('day(created_at)');
        $this->db->order_by('day(created_at) ASC');
        return $this->db->from('report_detail')->get()->result();
    }
    public function getThisYearReports() {
        $this->db->select("count(*) as total");
        $this->db->where('YEAR(created_at) = YEAR(CURRENT_DATE)');
        return $this->db->from('report_detail')->get()->row();
    }
    public function getThisYearReportsChart() {
        $this->db->select("monthname(created_at) as month, count(*) total");
        $this->db->where('YEAR(created_at) = YEAR(CURRENT_DATE)');
        $this->db->group_by('monthname(created_at)');
        $this->db->order_by('monthname(created_at) DESC');
        return $this->db->from('report_detail')->get()->result();
    }

    public function getTodayReports() {
        $this->db->select("u.name, r.day, rd.category");
        $this->db->from('user u');
        $this->db->join('report r', 'r.user_nisn = u.nisn', 'left');
        $this->db->join('report_detail rd', 'rd.report_id = r.report_id', 'left');
        $this->db->where('DATE(rd.created_at)', date('Y-m-d'));
        $this->db->group_by('rd.category');
        $this->db->group_by('u.nisn');
        $this->db->limit(6);
        return $this->db->get()->result();
    }
    public function getAvgCanceledReports() {
        $this->db->select("avg(day) as avg");
        $this->db->where('status', 'canceled');
        return $this->db->from('report')->get()->row();
        return $this->db->get()->result();
    }
    public function getAvgCanceledReportsChart() {
        $this->db->select("day, count(*) as total");
        $this->db->where('status', 'canceled');
        $this->db->group_by('day');
        $this->db->order_by('day ASC');
        return $this->db->from('report')->get()->result();
    }
}