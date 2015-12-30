<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 23-12-2015
 * Time: 13:17
 */class Report extends CI_Controller
{

    public function create()
    {
        $id = $this->uri->segment(3, 0);
        $this->load->model('report_model');
        $data['orderdetails']=$this->report_model->get_details($id);
        $data['templates']=$this->report_model->get_template();
        $this->load->view('lab/make_report',$data);



    }
    public function template()
    {

        $templateid=$this->uri->segment(3, 0);
        $orderid=$this->uri->segment(4, 0);
            $this->load->model('report_model');
        $template=$this->report_model->template_details($templateid);
        foreach($template as $row)
        {
            $filename=$row->filename;
        }
        $orderdetails=$this->report_model->get_details($orderid);
        foreach($orderdetails as $row)
        {
            $pname=$row->patient_name;
            $labno=$row->labno;
            $age=$row->age;

        }
        $this->load->helper('date');
        $date=date('Y-m-d');
        $user = $this->session->userdata('logged_in');
        $FileContent = file_get_contents('./Doctemplate/'.$filename);
        $name="jishnu";
        $FileContent=str_replace("*Patientname*" ,$pname,$FileContent);
        $FileContent=str_replace("*LabNo*" ,$labno,$FileContent);
        $FileContent=str_replace("*Age*" ,$age,$FileContent);
        $FileContent=str_replace("*date*" ,$date,$FileContent);
        $FileContent=str_replace("*By*" ,$user['username'],$FileContent);



        $fn = "./Doctemplate/".$pname.$filename.".rtf";
        file_put_contents($fn,$FileContent);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($fn).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fn));
        readfile($fn);
        $this->load->helper('file');
        unlink("./Doctemplate/".$pname.$filename.".rtf");
        exit;
    }


    public function upload_file()
    {

            $file_element_name  = $this->input->post('userfile');


            $config['upload_path'] = './reports/';
            $config['allowed_types'] = 'pdf';
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
    public function update_status()
    {
        $file_name=$this->input->post('filename');
        $order_id=$this->input->post('orderid');
        $this->load->helper('date');
        $user = $this->session->userdata('logged_in');
        $data=array("status"=>4,"report_name"=>$file_name,"certified_by"=>$user['username'],"certified_date_time"=>date('Y-m-d H:i:s'));
        $this->load->model("report_model");
        $update=$this->report_model->update_status($order_id,$data);
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

    /**
     *
     */
    public function view()
    {
        $this->load->helper('file');
        $id = $this->uri->segment(3, 0);
        $this->load->model("report_model");
        $filename=$this->report_model->report_name($id);
        foreach($filename as $row)
        {
            $filename=$row->report_name;
        }
        $file = './Reports/'.$filename;
        $filename = 'report .pdf';
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        @readfile($file);



    }
    public function delete_file()
    {
        $id = $this->input->post('orderid');
        $this->load->model("report_model");
        $filename=$this->report_model->report_name($id);
        foreach($filename as $row)
        {
            $filename=$row->report_name;
        }
        $file = './Reports/'.$filename;


        $oldfile = FCPATH . './Reports/'.$filename;;
        $newfile = FCPATH . './Reports/'.$filename.'_delete';

        rename($oldfile, $newfile);
        if(file_exists($file))
        {
            $response=array("status"=>false);
            echo json_encode($response);
        }
        else{
            $response=array("status"=>true);
            echo json_encode($response);
        }
    }
    public function ammend()
    {
        $id = $this->uri->segment(3, 0);
        $this->load->model('report_model');
        $data['orderdetails']=$this->report_model->get_details($id);
        $data['templates']=$this->report_model->get_template();
        $this->load->view('lab/ammend_report',$data);
    }

    public function ammend_upload_file()
    {

        $file_element_name  = $this->input->post('userfile');


        $config['upload_path'] = './Reports/';
        $config['allowed_types'] = 'pdf';
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
    public function ammend_update_status()
    {
        $file_name=$this->input->post('filename');
        $order_id=$this->input->post('orderid');
        $this->load->helper('date');
        $user = $this->session->userdata('logged_in');
        $data=array("status"=>5,"report_name"=>$file_name,"rectified_by"=>$user['username'],"rectified_date_time"=>date('Y-m-d H:i:s'));
        $this->load->model("report_model");
        $update=$this->report_model->update_status($order_id,$data);
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
}