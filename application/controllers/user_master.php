<?php

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 24-11-2015
 * Time: 14:06
 */
class User_master extends CI_Controller
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

        $this->load->model('user_model');

    }

    public function index()
    {
        $this->load->view('masters/user');
    }

    public function search()
    {
          $name = $this->input->post('name');
         $username=$this->input->post('username');
          if ($this->input->post('name') && !$this->input->post('username')) {


            if ($this->input->post('active')) {
                $active = 1;

            } else {
                $active = 0;
            }

            $result = $this->user_model->search_name($name, $active);
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>$row->username</td>";
                echo "<td>$row->name</td>";
                echo "<td>$row->user_desc</td>";
                if (($row->active_yesno) == 1) {
                    echo "<td class='label-success'>Active</td>";
                } else {
                    echo "<td class='label-danger'>Inactive</td>";
                }

                echo "<td class='hidden'>$row->id</td>";
                echo "<td><button class='btn btn-sm btn-primary' id='modify'>Modify</button>  <button class='btn btn-sm btn-primary' id='password'>Change Password</button></td>";
                echo "</tr>";

            }

        } elseif($this->input->post('username') && !$this->input->post('name')) {


              if ($this->input->post('active')) {
                  $active = 1;

              } else {
                  $active = 0;
              }

              $result = $this->user_model->search_username($username, $active);
              foreach ($result as $row) {
                  echo "<tr>";
                  echo "<td>$row->username</td>";
                  echo "<td>$row->name</td>";
                  echo "<td>$row->user_desc</td>";
                  if (($row->active_yesno) == 1) {
                      echo "<td class='label-success'>Active</td>";
                  } else {
                      echo "<td class='label-danger'>Inactive</td>";
                  }

                  echo "<td class='hidden'>$row->id</td>";
                  echo "<td><button class='btn btn-sm btn-primary' id='modify'>Modify</button><button class='btn btn-sm btn-primary' id='password'>Change Password</button></td>";
                  echo "</tr>";

              }
          }
          elseif($this->input->post('username') && $this->input->post('name')){

              if ($this->input->post('active')) {
                  $active = 1;

              } else {
                  $active = 0;
              }

              $result = $this->user_model->search_both($username,$name, $active);
              foreach ($result as $row) {
                  echo "<tr>";
                  echo "<td>$row->username</td>";
                  echo "<td>$row->name</td>";
                  echo "<td>$row->user_desc</td>";
                  if (($row->active_yesno) == 1) {
                      echo "<td class='label-success'>Active</td>";
                  } else {
                      echo "<td class='label-danger'>Inactive</td>";
                  }

                  echo "<td class='hidden'>$row->id</td>";
                  echo "<td><button class='btn btn-sm btn-primary' id='modify'>Modify</button> <button class='btn btn-sm btn-primary' id='password'>Change Password</button></td>";
                  echo "</tr>";

              }

          }

          else {
              if ($this->input->post('active')) {
                  $active = 1;

              } else {
                  $active = 0;
              }

              $result = $this->user_model->search_full($active);
              foreach ($result as $row) {
                  echo "<tr>";
                  echo "<td>$row->username</td>";
                  echo "<td>$row->name</td>";
                  echo "<td>$row->user_desc</td>";
                  if (($row->active_yesno) == 1) {
                      echo "<td class='label-success'>Active</td>";
                  } else {
                      echo "<td class='label-danger'>Inactive</td>";
                  }

                  echo "<td class='hidden'>$row->id</td>";
                  echo "<td><button class='btn btn-sm btn-primary' id='modify'>Modify</button>  <button class='btn btn-sm btn-primary' id='password'>Change Password</button></td>";
                  echo "</tr>";

              }

        }


    }

    public function add_new_view()
    {
        $this->load->view('masters/add_user');
    }

    public function add()
    {
        $username = $this->input->post('username');

        if ($this->input->post('active')) {
            $active = 1;

        } else {
            $active = 0;
        }

        $checkname = $this->user_model->check_name($username);
        if ($checkname) {
            $response = array(
                "check" => true

            );
            echo json_encode($response);
        } else {
            $data = array(
                "username" => $this->input->post('username'),
                "name"=>$this->input->post('name'),
                "user_desc"=>$this->input->post('user_desc'),
                "password"=>md5($this->input->post('passwd2')),
                "active_yesno" => $active
            );
            $status = $this->user_model->add($data);
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


        $data['user'] = $this->user_model->get_details($id);
        $this->load->view('masters/update_user', $data);
    }

    public function update()
    {
        $id=$this->input->post('id');
        $username=$this->input->post('username');
        if ($this->input->post('active')) {
            $active = 1;

        } else {
            $active = 0;
        }

        $checkname = $this->user_model->check_name_update($username, $id);
        if ($checkname) {
            $response = array(
                "check" => true

            );
            echo json_encode($response);
        } else {
            $data = array(
                "username" => $username,
                "name"=>$this->input->post('name'),
                "user_desc"=>$this->input->post('user_desc'),
                "active_yesno"=> $active
            );
            $status = $this->user_model->update($data, $id);
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

    public function update_password_view()
    {
        $id = $this->uri->segment(3, 0);


        $data['user'] = $this->user_model->get_details($id);
        $this->load->view('masters/update_password', $data);
    }
    public function password_update()
    {
        $id=$this->input->post('id');
        $passwd=md5($this->input->post('passwd2'));
         $data = array(
                "password" => $passwd );

            $status = $this->user_model->update($data, $id);
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