<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 11-11-2015
 * Time: 15:32
 */

class Login extends CI_Controller
{

    public function index()
    {
        $this->load->helper(array('form'));
        $this->load->view('login');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('role');

        $this->session->sess_destroy();
        redirect('login','refresh');
    }
}