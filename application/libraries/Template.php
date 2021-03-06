<?php

class Template {
    protected $_ci;

    function __construct(){
        $this->_ci = &get_instance();
    }
    public function view($content, $data){
        $this->_ci->load->view('template/header', $data); // Header
        $this->_ci->load->view($content, $data); // Content
        $this->_ci->load->view('template/footer', $data); // Footer
    }
}