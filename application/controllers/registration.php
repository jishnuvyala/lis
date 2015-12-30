<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 27-09-2015
 * Time: 14:53
 */

class Registration extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //checking user is logged in or not
        if(!$this->session->userdata('logged_in'))
        {
            redirect ('login','refresh');
        }
        if(!$this->session->userdata('role'))
        {
            redirect ('login','refresh');
        }

        $role=$this->session->userdata('role');
        //checking the user is billing staff/admin or not

        if(!$role['billing']  && !$role['admin'])
        {
            show_error('You are not autherized for this action.Please contact System Support' );
        }
        $this->load->model('registration_model');
        $this->load->library('form_validation');
        $this->load->helper('date');

    }
    //Showing registration page
    public function index()
    {
        
        $data['district'] = $this->registration_model->get_district();
        $data['gender'] = $this->registration_model->get_gender();
        $data['success']='false';
        $this->load->view('registration/registration', $data);

    }
    //Function for new registration
    public function add()
    {
        
//Server side valiation
        $this->form_validation->set_rules('fname', 'fname', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lname', 'lname', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('age', 'age', 'trim|required|xss_clean');
        $this->form_validation->set_rules('district', 'district', 'trim|required|xss_clean');
        $this->form_validation->set_rules('addr', 'addr', 'trim|xss_clean');
        $this->form_validation->set_rules('number', 'number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'trim|xss_clean');
//If validation fails .Showing error
        if ($this->form_validation->run() == FALSE) {
            $response['status']=false;
            echo json_encode($response);

        }
        else
        {
            
        $user=$this->session->userdata['logged_in'];
        $data=array(
         'first_name'=>$this->input->post('fname'),
         'last_name'=>$this->input->post('lname'),
         'gender'=>$this->input->post('gender'),
         'age'=>$this->input->post('age'),
         'state'=>$this->input->post('state'),
         'district'=>$this->input->post('district'),
         'address'=>$this->input->post('addr'),
         'phone_no'=>$this->input->post('number'),
         'email'=>$this->input->post('email'),
         'last_modified_by'=>$user['username'],
         'last_modified_on'=>date('Y-m-d H:i:s')

     );
       //Calling model
        $data=$this->registration_model->new_registration($data);
            //If insert is successful passing repsonse as true to ajax call
        if($data)
        {
            $response['id']=$data;
            $response['status']=true;
            echo json_encode($response);
        }
        else
        {
            $response['status']=false;
            echo json_encode($response);

        }



    }
    }


}