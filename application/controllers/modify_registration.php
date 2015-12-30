<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 15-11-2015
 * Time: 16:10
 */
class Modify_registration extends CI_Controller
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
    public function index()
    {    //Showing Modify Registration Page
        $data['district'] = $this->registration_model->get_district();
        $data['gender'] = $this->registration_model->get_gender();
        $this->load->view('registration/modify_registration', $data);
    }

    public function get_data()
    {   //Collecting patient Info and passing the details
        $id=$this->input->post('id');
        $data=$this->registration_model->get_patientinfo($id);
        if($data)
        {
            foreach($data as $row)
        {
            $response=array(
                "first_name"=>$row->first_name,
                "last_name"=>$row->last_name,
                "age"=>$row->age,
                "address"=>$row->address,
                "phone_no"=>$row->phone_no,
                "email"=>$row->email,
                "gender_id"=>$row->gender_id,
                "gender"=>$row->gender_name,
                "state_id"=>$row->state_id,
                "state"=>$row->state_name,
                "district_id"=>$row->district_id,
                "district"=>$row->district_name,
                "status"=>true
            );
        }
            echo json_encode($response);
            }
        else
        {
            $response['status']=false;
            echo json_encode($response);
        }
    }

    public function update()
    {  //Updating the patient data
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
        else{
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
        $id=$this->input->post('labno');
        
        $return=$this->registration_model->update($id,$data);
        $response['status']=$return;
        echo json_encode($response);
        }
    }
}