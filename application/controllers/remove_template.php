<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 29-12-2015
 * Time: 13:35
 */

class Remove_template extends CI_Controller
{

    public function index()
    {
        $this->load->model("templatemaster_model");
        $data['template']=$this->templatemaster_model->get_details();
        $this->load->view('masters/removetemplate',$data);
    }
}