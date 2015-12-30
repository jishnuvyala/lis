<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 23-11-2015
 * Time: 12:40
 */

class Cancel_order extends CI_Controller
{

    public function index()
    {
        $this->load->view('lab/cancel_order');
    }

    public function search()
    {
        $this->load->model('cancelorder_model');
        $labno = $this->input->post('labno');
        $frmdate = $this->input->post('frmdate');
        $todate = $this->input->post('todate');


        if ($this->input->post('ordered') and !$this->input->post('inprogress')) {

            $result = $this->cancelorder_model->search_status1($labno, $frmdate, $todate);
            foreach ($result as $row) {
                echo "<tr class='info'>";
                echo "<td>$row->patient</td>";
                echo "<td>$row->labno</td>";
                echo "<td>$row->service</td>";
                echo "<td class='hidden'>$row->service_orderid</td>";
                echo "<td>$row->order_created_by</td>";
                echo "<td>$row->ordered_date_time</td>";
                echo "<td>$row->status</td>";
                echo "<td><textarea class='input-md' placeholder='Enter Cancellation remarks' id='remarks'></textarea></td>";
                echo "<td><button class='btn btn-sm btn-info' id='cancel'>Cancel</button></td>";
                echo "</tr>";


            }


        }
        if ($this->input->post('inprogress') and !$this->input->post('ordered')) {

            $result = $this->cancelorder_model->search_status2($labno, $frmdate, $todate);
            foreach ($result as $row) {

                echo "<tr class='danger'>";
                echo "<td>$row->patient</td>";
                echo "<td>$row->labno</td>";
                echo "<td>$row->service</td>";
                echo "<td class='hidden'>$row->service_orderid</td>";
                echo "<td>$row->order_created_by</td>";
                echo "<td>$row->ordered_date_time</td>";
                echo "<td>$row->status</td>";
                echo "<td><textarea class='input-md' placeholder='Enter Cancellation remarks' id='remarks'></textarea></td>";
                echo "<td><button class='btn btn-sm btn-info' id='cancel'>Cancel</button></td>";
                echo "</tr>";


            }

        }
        if ($this->input->post('ordered') && $this->input->post('inprogress')) {

            $result = $this->cancelorder_model->search_statusboth($labno, $frmdate, $todate);
            foreach ($result as $row) {
                if ($row->order_status == 1) {
                    echo "<tr class='info'>";
                } else {
                    echo "<tr class='danger'>";
                }
                echo "<td>$row->patient</td>";
                echo "<td>$row->labno</td>";
                echo "<td>$row->service</td>";
                echo "<td class='hidden'>$row->service_orderid</td>";
                echo "<td>$row->order_created_by</td>";
                echo "<td>$row->ordered_date_time</td>";
                echo "<td>$row->status</td>";
                echo "<td><textarea class='input-md' placeholder='Enter Cancellation remarks' id='remarks'></textarea></td>";
                echo "<td><button class='btn btn-sm btn-info' id='cancel'>Cancel</button></td>";
                echo "</tr>";


            }

        }
    }

    public function cancel()
    {
        $this->load->model('cancelorder_model');
        $service_order_id=$this->input->post('orderid');
        $user=$this->session->userdata('logged_in');
        $remarks=$this->input->post('remarks');
        $this->load->helper('date');
        $data=array(
            "order_status"=>4,
            "refund_yesno"=>0,
            "cancelled_by"=>$user['username'],
            "cancelled_date_time"=>date('Y-m-d H:i:s'),
            "cancellation_remarks"=>$remarks
        );
        $service_order_update=$this->cancelorder_model->cancel_update($data,$service_order_id);
        if($service_order_update)
        {
            $data=array(
                "status"=>6
            );
            $laborder_update=$this->cancelorder_model->laborder_update($data,$service_order_id);
            if($laborder_update)
            {
                $response=array(
                    "status"=>true
                );
                echo json_encode($response);
            }
            else{
                $response=array(
                    "status"=>false
                );
                echo json_encode($response);
            }

        }
        else
        {
            $response=array(
                "status"=>false
            );
            echo json_encode($response);
        }
    }



}