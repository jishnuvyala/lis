<?php

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 24-11-2015
 * Time: 14:06
 */
class User_role_master extends CI_Controller
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
        if(!$role['master']  &&  !$role['admin'])
        {
            show_error('You are not autherized for this action.Please contact System Support' );
        }

        $this->load->model('user_role_model');

    }

    public function index()
    {
        $this->load->view('masters/user_role');
    }

    public function search()
    {

         $username=$this->input->post('username');
         $result = $this->user_role_model->search_role($username);
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>$row->username</td>";
                echo "<td>$row->name</td>";
                echo "<td class='label-info'>$row->role</td>";
                echo "<td class='hidden'>$row->role_id</td>";
                echo "<td class='hidden'>$row->user_id</td>";
                echo "<td><button class='btn btn-sm btn-warning' id='delete'>Delete</button></td>";
                echo "</tr>";

            }



    }

    public function add_new_view()
    {
        $this->load->view('masters/add_user_role');
    }

    public function get_details()
    {
        $username=$this->input->post('user');
        $result=$this->user_role_model->get_details($username);
        if(!$result)
        {
            $response=array(
                "status"=>false
            );
            echo json_encode($response);
        }
        else
        {
            foreach($result as $row)
            {
                $response=array(
                    "status"=>true,
                    "id"=>$row->id

                );
                echo json_encode($response);
            }
        }
    }

    public function add()
    {
        $userid = $this->input->post('id');
        $roleid = $this->input->post('role');

        if ($this->input->post('active')) {
            $active = 1;

        } else {
            $active = 0;
        }

        $checkrole = $this->user_role_model->check_map($userid,$roleid);
        if ($checkrole) {
            $response = array(
                "check" => true

            );
            echo json_encode($response);
        } else {
            $data = array(
               "user_id"=>$userid,
                "role_id"=>$roleid
            );
            $status = $this->user_role_model->add($data);
            if ($status) {
                $response = array(
                    "status" => true,
                    "check" => false
                );
                echo json_encode($response);
            } else {
                $response = array(
                    "status" => false,
                    "check" => false
                );
                echo json_encode($response);
            }
        }
    }


   public function delete()

   {
       $userid=$this->input->post('userid');
       $roleid=$this->input->post('roleid');
       $result=$this->user_role_model->delete($userid,$roleid);
       if($result)
       {
           $response=array(
               "status"=>true
           );
           echo json_encode($response);
       }
       else
       {
           $response=array(
               "status"=>false
           );
           echo json_encode($response);
       }
   }

}