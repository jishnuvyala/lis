<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 27-12-2015
 * Time: 14:09
 */

class Change_password extends CI_Controller
{

    public function index()
    {
        $this->load->view('changepassword');
    }
    public function password_update_user()
    {
        $this->load->model('user_model');
        $username=$this->input->post('username');
        $userid=$this->input->post('userid');
        $passwd=md5($this->input->post('passwd2'));
        $data = array(
            "password" => $passwd);

        $status = $this->user_model->update_user_password($data, $username,$userid);
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