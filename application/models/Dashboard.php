<?php

class Dashboard extends CI_Model {
    public function getUsers() {
        $this->db->select("count(*) as total");
        return $this->db->from('user')->get()->row();
    }
    public function getActiveReports() {
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
    public function getLastMonthReports() {
        $this->db->select("count(*) as total");
        $this->db->where('status', 'canceled');
        return $this->db->from('report')->get()->row();
    }
}