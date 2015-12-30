<?php

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 24-11-2015
 * Time: 14:06
 */
class Unit_master extends CI_Controller
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

        $this->load->model('unit_model');

    }

    public function index()
    {
        $this->load->view('masters/unit');
    }

    public function search()
    {
        $name = $this->input->post('name');
        if ($this->input->post('name')) {


            if ($this->input->post('active')) {
                $active = 1;

            } else {
                $active = 0;
            }

            $result = $this->unit_model->search($name, $active);
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>$row->name</td>";
                if (($row->active_yesno) == 1) {
                    echo "<td class='label-success'>Active</td>";
                } else {
                    echo "<td class='label-danger'>Inactive</td>";
                }

                echo "<td class='hidden'>$row->id</td>";
                echo "<td><button class='btn btn-sm btn-primary' id='modify'>Modify</button></td>";
                echo "</tr>";

            }

        } else {
            if ($this->input->post('active')) {
                $active = 1;

            } else {
                $active = 0;
            }

            $result = $this->unit_model->search_full($name, $active);
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>$row->name</td>";
                if (($row->active_yesno) == 1) {
                    echo "<td class='label-success'>Active</td>";
                } else {
                    echo "<td class='label-danger'>Inactive</td>";

                }
                echo "<td class='hidden'>$row->id</td>";
                echo "<td><button class='btn btn-sm btn-primary' id='modify'>Modify</button></td>";
                echo "</tr>";

            }


        }


    }

    public function add_new_view()
    {
        $this->load->view('masters/add_unit');
    }

    public function add()
    {
        $name = $this->input->post('unit_name');
        if ($this->input->post('active')) {
            $active = 1;

        } else {
            $active = 0;
        }

        $checkname = $this->unit_model->check_name($name);
        if ($checkname) {
            $response = array(
                "check" => true

            );
            echo json_encode($response);
        } else {
            $data = array(
                "name" => $name,
                "active_yesno" => $active
            );
            $status = $this->unit_model->add($data);
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

    public function update_view()
    {
        $id = $this->uri->segment(3, 0);


        $data['unit'] = $this->unit_model->get_details($id);
        $this->load->view('masters/update_unit', $data);
    }

    public function update()
    {
        $id=$this->input->post('id');
        $name=$this->input->post('unit_name');
        if ($this->input->post('active')) {
            $active = 1;

        } else {
            $active = 0;
        }

        $checkname = $this->unit_model->check_name_update($name, $id);
        if ($checkname) {
            $response = array(
                "check" => true

            );
            echo json_encode($response);
        } else {
            $data = array(
                "name" => $name,
                "active_yesno" => $active
            );
            $status = $this->unit_model->update($data, $id);
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
}