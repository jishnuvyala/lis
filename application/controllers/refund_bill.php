<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 14-12-2015
 * Time: 11:53
 */

class Refund_bill
    extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //checking user is logged in or not
        if (!$this->session->userdata('logged_in')) { redirect('login', 'refresh'); }

        if (!$this->session->userdata('role')) { redirect('login', 'refresh'); }
        $role=$this->session->userdata('role');

        //checking the user is billing staff/admin or not
        if (!$role['billing'] && !$role['admin'])
        { show_error('You are not autherized for this action.Please contact System Support'); }

        $this->load->model('billrefund_model');
    }

    public function index() { $this->load->view('bill/refund'); }

    public function findpatient()
    {
        $id=$this->input->post('id');
        $check=$this->billrefund_model->check_patient($id);

        if (!$check)
        {
            $response=array("status" => false);

            echo json_encode($response);
        }
        else
        {
            $data=$this->billrefund_model->get_patient($id);

            foreach ($data as $row)
            {
                $response=array
                (
                    "name" => $row->name,
                    "age" => $row->age,
                    "phone" => $row->phone_no,
                    "email" => $row->email,
                    "status" => true
                );

                echo json_encode($response);
            }
        }
    }

    public function get_cancelldetails()
    {
        $id=$this->input->post('id');
        $result=$this->billrefund_model->cancel_details($id);

        foreach ($result as $row)
        {
            echo "<tr>";

            echo "<td><input type='checkbox' class='checkbox case' style='width:50px;'/></td>";

            echo "<td>$row->name</td>";

            echo "<td class='hidden serviceid'>$row->service_id</td>";

            echo "<td class='hidden orderid'>$row->order_id</td>";

            echo "<td>$row->bill_no</td>";

            echo "<td class='tableprice'>$row->price</td>";

            echo "</tr>";
        }
    }

    public function add_bill()
    {
        $this->load->helper('date');
        $date=date('Y-m-d');
        $digits=3;
        $rand=rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $bill_no=$date . '-' . $rand;
        $user=$this->session->userdata('logged_in');
        $bill_data=array
        (
            "bill_no" => $bill_no,
            "total_amount" => $this->input->post('total'),
            "patient_id" => $this->input->post('id'),
            "created_by" => $user['username'],
            "created_date_time" => date('Y-m-d H:i:s')
        );

        $billid=$this->billrefund_model->bill($bill_data);

        if ($billid)
        {
            $serviceid=json_decode(stripslashes($this->input->post('serviceid')));

            foreach ($serviceid as $index => $code)
            {
                $data=array
                (
                    "refund_bill_id" => $billid,
                    "service_id" => $code
                );

                $status=$this->billrefund_model->refund_details($data);

                if ($status)
                {
                    $orderid=json_decode(stripslashes($this->input->post('orderid')));

                    foreach ($orderid as $index => $code2)
                    {
                        $update=array("refund_yesno" => 1);

                        $update_status=$this->billrefund_model->service_orderupdate($update, $code2);

                        if (!$update_status)
                        {
                            $response=array("status" => false);

                            echo json_encode($response);
                        }
                    }
                }
                else
                {
                    $response=array("status" => false);

                    echo json_encode($response);
                }
            }

            $response=array
            (
                "status" => true,
                "bill_id" => $billid
            );

            echo json_encode($response);
        }
        else
        {
            $response=array("status" => false);

            echo json_encode($response);
        }
    }
}