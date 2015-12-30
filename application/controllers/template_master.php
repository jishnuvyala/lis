<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 27-12-2015
 * Time: 19:43
 */
class Template_master extends CI_Controller
{

    public function index()
    {
        $this->load->view('masters/templatemaster');
    }
    public function upload_file()
    {

        $file_element_name  = $this->input->post('userfile');


        $config['upload_path'] = './Doctemplate/';
        $config['allowed_types'] = 'rtf';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload())
        {
            $response=array("status"=>false);
            echo json_encode($response);
        }
        else
        {
            $data = $this->upload->data();
            $file_path = $data['full_path'];
            $file_name=$data['file_name'];
            if(file_exists($file_path))
            {
                $response=array("status"=>true,"file_path"=>$file_path,"file_name"=>$file_name);
                echo json_encode($response);
            }
            else
            {
                $response=array("status"=>false);
                echo json_encode($response);
            }
        }



    }
    public function insert()
    {
        $file_name=$this->input->post('filename');
        $name=$this->input->post('name');
        $this->load->helper('date');

        $data=array("name"=>$name,"filename"=>$file_name,"active_yesno"=>1);
        $this->load->model("templatemaster_model");
        $update=$this->templatemaster_model->insert($data);
        if($update)
        {
            $response=array("status"=>true);
            echo json_encode($response);
        }
        else
        {
            $response=array("status"=>false);
            echo json_encode($response);
        }
    }
    public function remove()
    {
        $id=$this->input->post('id');
        $data=array("active_yesno"=>0);
        $this->load->model("templatemaster_model");
        $update=$this->templatemaster_model->update($id,$data);
        if($update)
        {
            $response=array("status"=>true);
            echo json_encode($response);
        }
        else
        {
            $response=array("status"=>false);
            echo json_encode($response);
        }


    }
    public function remove_view()
    {
        $this->load->model("templatemaster_model");
        $data['template']=$this->templatemaster_model->get_details();
        $this->load->view('masters/removetemplate',$data);
    }


}