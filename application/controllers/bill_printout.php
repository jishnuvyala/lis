<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 10-11-2015
 * Time: 21:50
 */

Class Bill_printout extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('billprint_view');


    }

    public function view()
    {
        $id = $this->uri->segment(3, 0);
        $data['bill']=$this->billprint_view->bill_view($id);
        $data['billdetails']=$this->billprint_view->billdetails_view($id);
        $data['company']=$this->billprint_view->company();
        $html= $this->load->view('bill/billprint',$data,true);
        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load();
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "I");


    }
    public function refund_view()
    {
        $id = $this->uri->segment(3, 0);
        $data['refund']=$this->billprint_view->refund_bill($id);
        $data['billdetails']=$this->billprint_view->refund_billdetails($id);
        $data['company']=$this->billprint_view->company();
        $html= $this->load->view('bill/refundbillprint',$data,true);
        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load();
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "I");

    }

}