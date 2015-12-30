<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 23-11-2015
 * Time: 12:40
 */

class Cancel_browser extends CI_Controller
{

    public function index()
    {
        $this->load->view('lab/cancel_browser');
    }

    public function search()
    {
        $this->load->model('cancelbrowser_model');
        $labno = $this->input->post('labno');
        $frmdate = $this->input->post('frmdate');
        $todate = $this->input->post('todate');



        if ($this->input->post('refundno') and !$this->input->post('labno')) {

            $result = $this->cancelbrowser_model->search1($frmdate, $todate);
            foreach ($result as $row) {
                echo "<tr >";
                echo "<td>$row->patient</td>";
                echo "<td>$row->labno</td>";
                echo "<td>$row->service</td>";
                echo "<td>$row->order_created_by</td>";
                echo "<td>$row->ordered_date_time</td>";
                if($row->refund_yesno==1)
                {
                   echo "<td><label class='label label-success'>Refund Given</label></td>";
                }
                else{
                    echo "<td><label class='label label-danger'>Pending</label></td>";
                }

                echo "<td>$row->cancelled_by</td>";
                echo "<td>$row->cancellation_remarks</td>";
                echo "<td>$row->cancelled_date_time</td>";
                echo "</tr>";


            }


        }
        if ($this->input->post('labno') and !$this->input->post('refundno')) {

            $result = $this->cancelbrowser_model->search2($labno, $frmdate, $todate);
            foreach ($result as $row) {
                echo "<tr >";
                echo "<td>$row->patient</td>";
                echo "<td>$row->labno</td>";
                echo "<td>$row->service</td>";
                echo "<td>$row->order_created_by</td>";
                echo "<td>$row->ordered_date_time</td>";
                if($row->refund_yesno==1)
                {
                    echo "<td><label class='label label-success'>Refund Given</label></td>";
                }
                else{
                    echo "<td><label class='label label-danger'>Pending</label></td>";
                }

                echo "<td>$row->cancelled_by</td>";
                echo "<td>$row->cancellation_remarks</td>";
                echo "<td>$row->cancelled_date_time</td>";
                echo "</tr>";


            }

        }
        if ($this->input->post('labno') and $this->input->post('refundno')) {

            $result = $this->cancelbrowser_model->search3($labno, $frmdate, $todate);
            foreach ($result as $row) {
                echo "<tr >";
                echo "<td>$row->patient</td>";
                echo "<td>$row->labno</td>";
                echo "<td>$row->service</td>";
                echo "<td>$row->order_created_by</td>";
                echo "<td>$row->ordered_date_time</td>";
                if($row->refund_yesno==1)
                {
                    echo "<td><label class='label label-success'>Refund Given</label></td>";
                }
                else{
                    echo "<td><label class='label label-danger'>Pending</label></td>";
                }

                echo "<td>$row->cancelled_by</td>";
                echo "<td>$row->cancellation_remarks</td>";
                echo "<td>$row->cancelled_date_time</td>";
                echo "</tr>";


            }
        }
        if (!$this->input->post('labno') and !$this->input->post('refundno')) {

            $result = $this->cancelbrowser_model->search4($frmdate, $todate);
            foreach ($result as $row) {
                echo "<tr >";
                echo "<td>$row->patient</td>";
                echo "<td>$row->labno</td>";
                echo "<td>$row->service</td>";
                echo "<td>$row->order_created_by</td>";
                echo "<td>$row->ordered_date_time</td>";
                if($row->refund_yesno==1)
                {
                    echo "<td><label class='label label-success'>Refund Given</label></td>";
                }
                else{
                    echo "<td><label class='label label-danger'>Pending</label></td>";
                }

                echo "<td>$row->cancelled_by</td>";
                echo "<td>$row->cancellation_remarks</td>";
                echo "<td>$row->cancelled_date_time</td>";
                echo "</tr>";


            }
        }

    }





}