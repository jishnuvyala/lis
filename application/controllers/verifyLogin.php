<?php

class VerifyLogin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user', '', TRUE);
    }

    function index()
    {
//This method will have the credentials validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|callback_check_database');

        if ($this->form_validation->run() == FALSE) {
//Field validation failed.  User redirected to login page
            $this->load->view('login');
        } else {
//Go to private area
            redirect('dashboard', 'refresh');
        }

    }

    function check_database()
    {
//Field validation succeeded.  Validate against database
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
//query the database
        $result = $this->user->login($username, $password);

        if ($result) {
            $sess_array_login = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'id' => $row->id,
                    'username' => $row->username,
                    "name"=>$row->name
                );
                //query the database for user role
                $id = $row->id;
                $this->session->set_userdata('logged_in', $sess_array);
            }
            $role = array(
                "billing" => false,
                "labuser" => false,
                "labmanager" => false,
                "master" => false,
                "admin" => false
            );

            $result = $this->user->role($id);
            if ($result) {
                foreach ($result as $row) {
                    //Assign Variable for each role which is used for Menu display based on roles
                    if ($row->role_id == 1) {
                        $role['billing'] = true;
                    } elseif ($row->role_id == 2) {
                        $role['labuser'] = true;
                    } elseif ($row->role_id == 3) {
                        $role['labmanager'] = true;
                    } elseif ($row->role_id == 4) {
                        $role['master'] = true;
                    } elseif ($row->role_id == 5) {
                        $role['admin'] = true;
                    }
                }
                $this->session->set_userdata('role', $role);
                return true;
            } else {
                //if role is mapped returning false with message
                $this->form_validation->set_message('check_database', 'No role is mapped to the user');
                return false;
            }
        } else {
            //if user is not available return false with message
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }
}

?>