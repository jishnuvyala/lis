<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 12-11-2015
 * Time: 15:55
 */

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in'))
        {
            redirect ('login','refresh');
        }
        if(!$this->session->userdata('role'))
        {
            redirect ('login','refresh');
        }
    }
    public function index()
    {
        $this->load->model('dashboard_view');
        $data['qoutes']=$this->dashboard_view->qoutes();
        $user=$this->session->userdata('logged_in');
        $data['totalcoll']=$this->dashboard_view->total_collection($user['username']);
        $data['totalrefund']=$this->dashboard_view->total_refund($user['username']);
        $data['totalcancel']=$this->dashboard_view->total_cancel();
        $data['totalreg']=$this->dashboard_view->total_reg($user['username']);
        $data['pendingcoll']=$this->dashboard_view->total_pending_collection();
        $data['pendingentry']=$this->dashboard_view->total_pending_saved();
        $data['pendingcertify']=$this->dashboard_view->total_pending_certify();
        $data['pendingreports']=$this->dashboard_view->total_pending_report();
        $this->load->view('dashboard/dashboard',$data);

    }
}