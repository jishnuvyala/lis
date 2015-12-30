<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 14-12-2015
 * Time: 11:53
 */

class Patient_browser extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //checking user is logged in or not
        if (!$this->session->userdata('logged_in')) {
            redirect('login', 'refresh');
        }
        if (!$this->session->userdata('role')) {
            redirect('login', 'refresh');
        }
        $role = $this->session->userdata('role');
        //checking the user is billing staff/admin or not
        if (!$role['billing'] && !$role['admin']) {
            show_error('You are not autherized for this action.Please contact System Support');
        }

        $this->load->model('patientbrowser_model');

    }
    public function index()
    {
        $this->load->view('registration/patientbrowser');

    }

    public function search()
    {
        if($this->input->post('fname'))
        {
          $fname=$this->input->post('fname');
        }
        else
        {
            $fname='';
        }
        if($this->input->post('lname'))
        {
            $lname=$this->input->post('lname');
        }
        else
        {
            $lname='';
        }
        if($this->input->post('age'))
        {
            $age=$this->input->post('age');
        }
        else
        {
            $age='';
        }
        if($this->input->post('addr'))
        {
            $addr=$this->input->post('addr');
        }
        else
        {
            $addr='';
        }
        if($this->input->post('phone'))
        {
            $phone=$this->input->post('phone');
        }
        else
        {
            $phone='';
        }
        if($this->input->post('email'))
        {
            $email=$this->input->post('email');
        }
        else
        {
            $email='';
        }
        $result=$this->patientbrowser_model->search($fname,$lname,$age,$addr,$phone,$email);
        foreach ($result as $row) {
            echo "<tr class='info'>";
            echo "<td>$row->id</td>";
            echo "<td>$row->first_name</td>";
            echo "<td>$row->last_name</td>";
            echo "<td >$row->age</td>";
            echo "<td>$row->gender</td>";
            echo "<td>$row->address</td>";
            echo "<td>$row->phone_no</td>";
            echo "<td>$row->email</td>";
            echo "<td>$row->district</td>";
            echo "<td>$row->state</td>";
            echo "</tr>";
        }
    }
}