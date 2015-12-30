<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 25-12-2015
 * Time: 09:12
 */

class Lab_result extends CI_Controller
{


    public function index()

    {
        $this->load->model('billprint_view');
        $data['company']=$this->billprint_view->company();
        $this->load->view('lab/labresult',$data);
    }

}