<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller 
{
    public $user;
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('parser');
        $this->load->helper('url');
        // if($this->session->userdata('loggedIn'))
        if($this->session->userdata('loggedIn'))
        {
            // echo 'hi';
            // var_dump($this->session->loggedIn);
            $this->user= $this->session->userdata('loggedIn');
            
            // redirect(base_url().'welcome');
        }
        else
        {
            // var_dump (base_url());
            // exit();
            redirect(base_url().'welcome/login');
            // exit();
            // $this->load->view('login.php');
        }
    }

}
