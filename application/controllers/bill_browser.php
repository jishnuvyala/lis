<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 14-12-2015
 * Time: 11:53
 */

class Bill_browser
    extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //checking user is logged in or not
        if (!$this->session->userdata('logged_in'))
        {
            redirect('login', 'refresh');
        }

        if (!$this->session->userdata('role'))
        {
            redirect('login', 'refresh');
        }
        $role = $this->session->userdata('role');

        //checking the user is billing staff/admin or not
        if (!$role['billing'] && !$role['admin'])
        {
            show_error('You are not autherized for this action.Please contact System Support');
        }

        $this->load->model('billbrowser_model');
    }

    public function index() { $this->load->view('bill/billbrowser'); }

    public function search()
    {
        $labno = $this->input->post('labno');
        $frmdate = $this->input->post('frmdate');
        $todate = $this->input->post('todate');
        $billno = $this->input->post('billno');

        if ($this->input->post('labno') && !$this->input->post('billno'))
        {
            $result = $this->billbrowser_model->search_labno($labno, $frmdate, $todate);

            foreach ($result as $row)
            {
                echo "<tr class>";

                echo "<td>$row->patient</td>";

                echo "<td><label class='label label-primary'>$row->labno</label> </td>";

                echo "<td><label class='label label-danger'> $row->bill_no</label></td>";

                echo "<td class='hidden'>$row->id</td>";

                echo "<td>$row->bill_amount</td>";

                echo "<td>$row->discount_percentage</td>";

                echo "<td>$row->total_amount</td>";

                echo "<td>$row->created_by</td>";

                echo "<td>$row->created_date</td>";

                echo "<td><button class='btn btn-sm btn-info' id='print'>Print</button></td>";

                echo "</tr>";
            }
        }

        if (!$this->input->post('labno') && $this->input->post('billno'))
        {
            $result = $this->billbrowser_model->search_billno($billno, $frmdate, $todate);

            foreach ($result as $row)
            {
                echo "<tr class>";

                echo "<td>$row->patient</td>";

                echo "<td><label class='label label-primary'>$row->labno</label> </td>";

                echo "<td><label class='label label-danger'> $row->bill_no</label></td>";

                echo "<td class='hidden'>$row->id</td>";

                echo "<td>$row->bill_amount</td>";

                echo "<td>$row->discount_percentage</td>";

                echo "<td>$row->total_amount</td>";

                echo "<td>$row->created_by</td>";

                echo "<td>$row->created_date</td>";

                echo "<td><button class='btn btn-sm btn-info' id='print'>Print</button></td>";

                echo "</tr>";
            }
        }

        if ($this->input->post('labno') && $this->input->post('billno'))
        {
            $result = $this->billbrowser_model->search_both($labno, $billno, $frmdate, $todate);

            foreach ($result as $row)
            {
                echo "<tr class>";

                echo "<td>$row->patient</td>";

                echo "<td><label class='label label-primary'>$row->labno</label> </td>";

                echo "<td><label class='label label-danger'> $row->bill_no</label></td>";

                echo "<td class='hidden'>$row->id</td>";

                echo "<td>$row->bill_amount</td>";

                echo "<td>$row->discount_percentage</td>";

                echo "<td>$row->total_amount</td>";

                echo "<td>$row->created_by</td>";

                echo "<td>$row->created_date</td>";

                echo "<td><button class='btn btn-sm btn-info' id='print'>Print</button></td>";

                echo "</tr>";
            }
        }

        if (!$this->input->post('labno') && !$this->input->post('billno'))
        {
            $result = $this->billbrowser_model->search($frmdate, $todate);

            foreach ($result as $row)
            {
                echo "<tr class>";

                echo "<td>$row->patient</td>";

                echo "<td><label class='label label-primary'>$row->labno</label> </td>";

                echo "<td><label class='label label-danger'> $row->bill_no</label></td>";

                echo "<td class='hidden'>$row->id</td>";

                echo "<td>$row->bill_amount</td>";

                echo "<td>$row->discount_percentage</td>";

                echo "<td>$row->total_amount</td>";

                echo "<td>$row->created_by</td>";

                echo "<td>$row->created_date</td>";

                echo "<td><button class='btn btn-sm btn-info' id='print'>Print</button></td>";

                echo "</tr>";
            }
        }
    }
}