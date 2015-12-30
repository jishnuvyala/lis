<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 27-09-2015
 * Time: 14:53
 */

class Card extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

            //checking user is logged in or not

            $this->load->model('registration_model');
            $this->load->library('zend');

    }

    public function view()
    {
        $id = $this->uri->segment(3, 0);
        $data['card']=$this->registration_model->card_view($id);


        $html=$this->load->view('registration/card', $data, true);
        $pdfFilePath = "lab.pdf";
        $this->load->library('m_pdf',"'utf-8', 'A7'");
        $this->pdf = $this->m_pdf->load();
        $this->pdf->WriteHTML($html);
        $this->pdf->Output($pdfFilePath,'I');

    }

    public function barcode()
    {
        $code = $this->uri->segment(3, 0);
        //load library

        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //generate barcode
        $barcode=Zend_Barcode::render('code128', 'image', array('text'=>$code), array());

    }
}

