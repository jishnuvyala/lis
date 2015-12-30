<?php

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 24-11-2015
 * Time: 14:06
 */
class Service_master extends CI_Controller
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
        if (!$role['master'] && !$role['admin']) {
            show_error('You are not autherized for this action.Please contact System Support');
        }

        $this->load->model('service_model');

    }

    public function index()
    {
        $data['category'] = $this->service_model->get_category();
        $data['specimen'] = $this->service_model->get_specimen();
        $data['unit'] = $this->service_model->get_unit();

        $this->load->view('masters/service', $data);
    }

    public function search()
    {
        if ($this->input->post('category') != 'default') {
            $category = $this->input->post('category');
        } else {
            $category = '';
        }
        if ($this->input->post('result_type') != 'default') {
            $result_type = $this->input->post('result_type');
        } else {
            $result_type = '';

        }


        $name = $this->input->post('name');
        $panel = $this->input->post('panel');
        if ($this->input->post('active')) {
            $active_yesno = 1;
        } else {
            $active_yesno = 0;
        }
        if (!$panel) {
            $result = $this->service_model->search($name, $category, $result_type, $active_yesno);
        } else {
            $result = $this->service_model->search_p($name, $category, $result_type, $panel, $active_yesno);
        }


        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>$row->name</td>";
            echo "<td>$row->category</td>";
            echo "<td>$row->result_type</td>";
            echo "<td>$row->price</td>";
            if ($row->active_yesno == 1) {
                echo "<td class='label-success'>active</td>";
            } else {
                echo "<td class='label-danger'>active</td>";
            }
            echo "<td class='hidden'>$row->service_id</td>";
            echo "<td><button class='btn btn-sm btn-primary' id='modify'>Modify</button></td>";
            echo "</tr>";

        }


    }

    public function add_new_view()
    {
        $data['category'] = $this->service_model->get_category();
        $data['specimen'] = $this->service_model->get_specimen();
        $data['unit'] = $this->service_model->get_unit();
        $data['container'] = $this->service_model->get_container();
        $this->load->view('masters/add_service', $data);
    }

    public function add()
    {
        $name = $this->input->post('name');
        $price = $this->input->post('price');
        $specimen = $this->input->post('specimen');
        $container = $this->input->post('container');
        $category = $this->input->post('category');
        $result_type = $this->input->post('result_type');
        $range_frm = $this->input->post('range_frm');
        $alpha_normal = $this->input->post('alpha_normal');
        $unit = $this->input->post('unit');
        $range_to = $this->input->post('range_to');
        $active = $this->input->post('active');
        if ($this->input->post('panel')) {
            $name = $name . "[panel]";
        }
        $checkname = $this->service_model->check_name($name);
        if ($checkname) {
            $response = array("check" => true);
            echo json_encode($response);

        } else {


            if ($this->input->post('panel')) {

                $data = array(
                    "name" => $name,
                    "price" => $price,
                    "panel_yesno" => 1,
                    "active_yesno" => $active,
                    "category_id" => $category
                );
                $insert = $this->service_model->add_service($data);
                $response = array(
                    "status" => $insert,
                    "check" => false
                );
                echo json_encode($response);

            } else {
                if ($result_type == 'A') {
                    $data = array(
                        "name" => $name,
                        "price" => $price,
                        "panel_yesno" => 0,
                        "active_yesno" => $active,
                        "specimen_id" => $specimen,
                        "container_id" => $container,
                        "category_id" => $category,
                        "result_type" => $result_type
                    );

                } else {
                    $data = array(
                        "name" => $name,
                        "price" => $price,
                        "panel_yesno" => 0,
                        "active_yesno" => $active,
                        "specimen_id" => $specimen,
                        "container_id" => $container,
                        "category_id" => $category,
                        "unit_id" => $unit,
                        "result_type" => $result_type
                    );
                }
                $insert = $this->service_model->add_service($data);
                if ($insert) {
                    if ($result_type == 'N') {
                        $data = array(
                            "service_id" => $insert,
                            "from_range" => $range_frm,
                            "to_range" => $range_to
                        );
                        $insert_numeric = $this->service_model->add_numericresult($data);
                        if ($insert_numeric) {
                            $response = array("status" => true, "check" => false);
                            echo json_encode($response);
                        } else {
                            $response = array("status" => false, "check" => false);
                            echo json_encode($response);
                        }
                    }
                    if ($result_type == 'A') {
                        $data = array(
                            "service_id" => $insert,
                            "alpha_normal" => $alpha_normal

                        );
                        $insert_alpha = $this->service_model->add_alpharange($data);
                        if ($insert_alpha) {
                            $response = array("status" => true, "check" => false);
                            echo json_encode($response);
                        } else {
                            $response = array("status" => false, "check" => false);
                            echo json_encode($response);
                        }
                    }


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

    public function update_view()
    {
        $id = $this->uri->segment(3, 0);
        $data['service'] = $this->service_model->get_details($id);
        $data['category'] = $this->service_model->get_category();
        $data['specimen'] = $this->service_model->get_specimen();
        $data['unit'] = $this->service_model->get_unit();
        $data['container'] = $this->service_model->get_container();
        $this->load->view('masters/update_service', $data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $price = $this->input->post('price');
        $specimen = $this->input->post('specimen');
        $container = $this->input->post('container');
        $category = $this->input->post('category');
        $result_type = $this->input->post('result_type');
        $range_frm = $this->input->post('range_frm');
        $alpha_normal = $this->input->post('alpha_normal');
        $unit = $this->input->post('unit');
        $range_to = $this->input->post('range_to');
        if ($this->input->post('active')) {
            $active = 1;

        } else {
            $active = 0;
        }

        $checkname = $this->service_model->check_name_update($name, $id);
        if ($checkname) {
            $response = array(
                "check" => true

            );
            echo json_encode($response);
        } else {
            if ($this->input->post('panel')) {

                $data = array(
                    "name" => $name,
                    "price" => $price,
                    "panel_yesno" => 1,
                    "active_yesno" => $active,
                    "category_id" => $category
                );
                $update = $this->service_model->update_service($data,$id);
                $response = array(
                    "status" => $update,
                    "check" => false
                );
                echo json_encode($response);

            } else {
                if ($result_type == 'A') {
                    $data = array(
                        "name" => $name,
                        "price" => $price,
                        "panel_yesno" => 0,
                        "active_yesno" => $active,
                        "specimen_id" => $specimen,
                        "container_id" => $container,
                        "category_id" => $category,
                        "result_type" => $result_type
                    );

                } else {
                    $data = array(
                        "name" => $name,
                        "price" => $price,
                        "panel_yesno" => 0,
                        "active_yesno" => $active,
                        "specimen_id" => $specimen,
                        "container_id" => $container,
                        "category_id" => $category,
                        "unit_id" => $unit,
                        "result_type" => $result_type
                    );
                }
                   $insert = $this->service_model->update_service($data,$id);
                if ($insert) {
                    if ($result_type == 'N') {
                        $data = array(
                            "from_range" => $range_frm,
                            "to_range" => $range_to
                        );
                        $insert_numeric = $this->service_model->update_numericresult($data,$id);
                        if ($insert_numeric) {
                            $response = array("status" => true, "check" => false);
                            echo json_encode($response);
                        } else {
                            $response = array("status" => false, "check" => false);
                            echo json_encode($response);
                        }
                    }
                    if ($result_type == 'A') {
                        $data = array(

                            "alpha_normal" => $alpha_normal

                        );
                        $insert_alpha = $this->service_model->update_alpharange($data,$id);
                        if ($insert_alpha) {
                            $response = array("status" => true, "check" => false);
                            echo json_encode($response);
                        } else {
                            $response = array("status" => false, "check" => false);
                            echo json_encode($response);
                        }
                    }


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
}