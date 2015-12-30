<?php

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 24-11-2015
 * Time: 14:06
 */
class Panel_service_master extends CI_Controller
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

        $this->load->model('panel_service_model');

    }

    public function index()
    {
       $data['panel']=$this->panel_service_model->find_panel();
        $this->load->view('masters/panel_service_map',$data);

    }

    public function search()
    {

         $panel_id=$this->input->post('panel');
         $result = $this->panel_service_model->search_mapping($panel_id);
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>$row->panel</td>";
                echo "<td>$row->service</td>";
                echo "<td class='hidden'>$row->panel_id</td>";
                echo "<td class='hidden'>$row->service_id</td>";
                echo "<td><button class='btn btn-sm btn-warning' id='delete'>Delete</button></td>";
                echo "</tr>";

            }



    }

    public function add_new_view()
    {
        $data['panel']=$this->panel_service_model->find_panel();
        $data['service']=$this->panel_service_model->find_service();
        $this->load->view('masters/add_panel_service',$data);
    }



    public function add()
    {
        $panel_id = $this->input->post('panel');
        $service_id = $this->input->post('service');

        if ($this->input->post('active')) {
            $active = 1;

        } else {
            $active = 0;
        }

        $checkmapping = $this->panel_service_model->check_map($panel_id,$service_id);
        if ($checkmapping) {
            $response = array(
                "check" => true

            );
            echo json_encode($response);
        } else {
            $data = array(
               "panel_id"=>$panel_id,
                "service_id"=>$service_id
            );
            $status = $this->panel_service_model->add($data);
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
       $panel_id = $this->input->post('panelid');
       $service_id = $this->input->post('serviceid');
       $result=$this->panel_service_model->delete($panel_id,$service_id);
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