<?php

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 22-12-2015
 * Time: 15:28
 */
class Result_browser extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        //checking user is logged in or not
        if (!$this->session->userdata('logged_in')) {
            redirect('login', 'refresh');
        }
        $this->load->model('resultbrowser_model');
    }

    public function index()
    {
        $this->load->view('lab/resultbrowser');
    }

    public function search()
    {
        $labno = $this->input->post('labno');
        $frmdate = $this->input->post('frmdate');
        $todate = $this->input->post('todate');
        $result = $this->resultbrowser_model->search($labno, $frmdate, $todate);
        foreach ($result as $row) {
            if ($row->result_type == 'N') {
                echo "<tr >";

                echo "<td>$row->patient_name</td>";

                echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                if ($row->panel_yesno == 1) {
                    echo
                    "<td style='width:10%'><label class='text-warning'}>$row->order_service</label><label class=' text-primary'>--$row->lab_service </label></td>";
                } else {
                    echo "<td><label class=' text-primary'>$row->lab_service</label></td>";
                }
                echo "<td class='hidden'>$row->orderid</td>";

                echo "<td>$row->method</td>";
                echo "<td>$row->normal_range_from - $row->normal_range_to </td>";
                echo "<td>$row->unit</td>";

                if ($row->numeric_result < $row->normal_range_from || $row->numeric_result > $row->normal_range_to) {
                    echo
                    "<td><label class='label label-danger'>$row->numeric_result</label></td>";
                } else {
                    echo "<td><label class='label label-success'>$row->numeric_result</label></td>";
                }
                if ($row->result_status = 'Certified') {
                    echo "<td><label class='label label-primary'>$row->result_status</label></td>";
                } else {
                    echo "<td><label class='label label-warning'>$row->result_status</label></td>";
                }
                if ($row->result_status = 'Certified') {
                    echo "<td>$row->certified_date_time</td>";
                } else {
                    echo "<td>$row->rectified_date_time</td>";
                }
                if ($row->result_status = 'Certified') {
                    echo "<td> Certified By :$row->certified_by</td>";
                } else {
                    echo "<td> Rectified By :$row->rectified_by</td>";
                }


                echo "</tr>";
            }

            if ($row->result_type == 'A') {
                echo "<tr >";

                echo "<td>$row->patient_name</td>";

                echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                if ($row->panel_yesno == 1) {
                    echo
                    "<td style='width:10%'><label class='text-warning'}>$row->order_service</label><label class=' text-primary'>--$row->lab_service </label></td>";
                } else {
                    echo "<td><label class=' text-primary'>$row->lab_service</label></td>";
                }
                echo "<td class='hidden'>$row->orderid</td>";
                echo "<td>$row->method</td>";
                echo "<td></td>";
                echo "<td></td>";

                if ($row->alpha_normal != $row->alpha_result) {
                    echo
                    "<td><label class='label label-danger'>$row->alpha_result</label></td>";
                } else {
                    echo "<td><label class='label label-success'>$row->alpha_result</label></td>";
                }
                if ($row->result_status == 'Certified') {
                    echo "<td><label class='label label-primary'>$row->result_status</label></td>";
                } else {
                    echo "<td><label class='label label-warning'>$row->result_status</label></td>";
                }
                if ($row->result_status == 'Certified') {
                    echo "<td>$row->certified_date_time</td>";
                } else {
                    echo "<td>$row->rectified_date_time</td>";
                }
                if ($row->result_status == 'Certified') {
                    echo "<td> Certified By :$row->certified_by</td>";
                } else {
                    echo "<td> Rectified By :$row->rectified_by</td>";
                }


                echo "</tr>";
            }
            if ($row->result_type == 'R') {
                echo "<tr >";

                echo "<td>$row->patient_name</td>";

                echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                if ($row->panel_yesno == 1) {
                    echo
                    "<td style='width:10%'><label class='text-warning'}>$row->order_service</label><label class=' text-primary'>--$row->lab_service </label></td>";
                } else {
                    echo "<td><label class=' text-primary'>$row->lab_service</label></td>";
                }
                echo "<td class='hidden'>$row->orderid</td>";


                echo "<td>$row->method</td>";
                echo "<td></td>";
                echo "<td></td>";

                echo "<td><a class='btn btn-xs btn-primary' id='viewreport'>View Report</a></td>";
                if ($row->result_status == 'Certified') {
                    echo "<td><label class='label label-primary'>$row->result_status</label></td>";
                } else {
                    echo "<td><label class='label label-warning'>$row->result_status</label></td>";
                }
                if ($row->result_status == 'Certified') {
                    echo "<td>$row->certified_date_time</td>";
                } else {
                    echo "<td>$row->rectified_date_time</td>";
                }
                if ($row->result_status == 'Certified') {
                    echo "<td> Certified By :$row->certified_by</td>";
                } else {
                    echo "<td> Rectified By :$row->rectified_by</td>";
                }


                echo "</tr>";
            }
        }


    }

    public function print_result()
    {
        $labno = $this->uri->segment(3, 0);
        $frmdate = $this->uri->segment(4, 0);
        $todate = $this->uri->segment(5, 0);
        $this->load->model('billprint_view');
        $data['company']=$this->billprint_view->company();
        $data['result']=$this->resultbrowser_model->result_print($labno,$frmdate,$todate);
        $data['patient']=$this->resultbrowser_model->patient_info($labno);
       $this->load->view('lab/labresult',$data);


    }


}