<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 12-11-2015
 * Time: 21:08
 */
class Result_processing
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
        if (!$role['labuser'] && !$role['labmanager'] && !$role['admin'])
        {
            show_error('You are not autherized for this action.Please contact System Support');
        }

        $this->load->helper('date');
        $this->load->model('resultprocessing');
        $this->load->model('service_order');
    }

    public function index() {

        $this->load->view('lab/processresult'); }

    public function search()
    {
        $labno = $this->input->post('labno');
        $frmdate = $this->input->post('frmdate');
        $todate = $this->input->post('todate');
        $status = $this->input->post('status');
        $method = $this->resultprocessing->getmethod();
        $role = $this->session->userdata('role');

        if ($status == 2)
        {
            if ($this->input->post('labno'))
            {
                $result = $this->resultprocessing->search_labno($labno, $frmdate, $todate);
            }
            else
            {
                $result = $this->resultprocessing->search_date($frmdate, $todate);
            }

            foreach ($result as $row)
            {
                if ($row->result_type == 'N')
                {
                    echo "<tr >";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td style='width:10%'><label class='label label-warning'>$row->order_service</label><label class=' text-info'>&nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td>$row->normal_range_from</td>";

                    echo "<td>$row->normal_range_to</td>";

                    echo "<td id='alphanormal' class='hidden'>$row->alpha_normal</td>";

                    echo "<td>$row->unit</td>";

                    echo " <td class='center'> <select id='method' name='method' class='input-sm' style='width: 100px'> ";

                    foreach ($method as $row1)
                    {
                        echo "<option value='$row1->id'> $row1->name</option>";
                    }

                    echo "</select></td>";

                    if ($row->priority!='High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    echo "<td><input type='number' name='numresult' id='numresult' class='input-sm' style='width: 100px'></td>";

                    echo
                    "<td><div class='btn-group btn-group-sm'>
                             <button type='button' class='btn  btn-primary' id='numsave'>Save</button>
                             <button type='button' class='btn btn-primary' id='numcertify'>Certify</button></div></td>";

                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen</td>";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }

                if ($row->result_type == 'A')
                {
                    echo "<tr>";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td style='width:20%'><label class='label label-warning'>$row->order_service</label><label class=' text-info'>  &nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td style='width:20%'><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td>$row->normal_range_from</td>";

                    echo "<td>$row->normal_range_to</td>";

                    echo "<td id='alphanormal' class='hidden'>$row->alpha_normal</td>";

                    echo "<td>$row->unit</td>";

                    echo " <td class='center'> <select id='method' name='method' class='input-sm' style='width: 100px'> ";

                    foreach ($method as $row1)
                    {
                        echo "<option value='$row1->id'> $row1->name</option>";
                    }

                    echo "</select></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    echo "<td><input class='input-sm' type='text' name='alpharesult' id='alpharesult' style='width: 100px'></td>";

                    echo
                    "<td><div class='btn-group btn-group-sm'>
                             <button type='button' class='btn  btn-primary' id='alphasave'>Save</button>
                             <button type='button' class='btn btn-primary' id='alphacertify'>Certify</button></div></td>";

                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen</td>";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }

                if ($row->result_type == 'R')
                {
                    echo "<tr >";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td><label class='label label-warning'>$row->order_service</label><label class=' text-info'>&nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td>$row->normal_range_from</td>";

                    echo "<td>$row->normal_range_to</td>";

                    echo "<td id='alphanormal' class='hidden'>$row->alpha_normal</td>";

                    echo "<td></td>";

                    echo " <td></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    echo "<td></td>";

                    echo "<td><a class='btn btn-xs btn-primary' id='makereport' >Make Report</a></td>";

                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }
            }
        }

        if ($status == 3)
        {
            if ($this->input->post('labno'))
            {
                $result = $this->resultprocessing->search_labno_status3($labno, $frmdate, $todate);
            }
            else
            {
                $result = $this->resultprocessing->search_date_status3($frmdate, $todate);
            }

            foreach ($result as $row)
            {
                if ($row->result_type == 'N')
                {
                    echo "<tr>";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td><label class='label label-warning'>$row->order_service</label><label class=' text-info'>  &nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td>$row->normal_range_from</td>";

                    echo "<td>$row->normal_range_to</td>";

                    echo "<td id='alphanormal' class='hidden'>$row->alpha_normal</td>";

                    echo "<td>$row->unit</td>";

                    echo " <td class='center'> <select id='method' name='method' class='input-sm' style='width: 100px'> ";

                    foreach ($method as $row1)
                    {
                        if ($row1->id == $row->method_id)
                        {
                            echo "<option value='$row1->id' selected> $row1->name</option>";
                        }
                        else
                        {
                            echo "<option value='$row1->id'> $row1->name</option>";
                        }
                    }

                    echo "</select></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    if ($row->numeric_result < $row->normal_range_from )
                    {
                        echo
                        "<td><input type='number' name='numresult' id='numresult' class='input-sm highlightblue' style='width: 100px' value='$row->numeric_result' ></td>";
                    }
                    elseif($row->numeric_result > $row->normal_range_to)
                    {
                        echo
                        "<td><input type='number' name='numresult' id='numresult' class='input-sm highlightred' style='width: 100px' value='$row->numeric_result' ></td>";
                    }
                    else
                    {
                        echo
                        "<td><input type='number' name='numresult' id='numresult' class='input-sm highlightgreen' style='width: 100px' value='$row->numeric_result' ></td>";
                    }

                    echo "<td><button type='button' class='btn btn-xs btn-primary' id='numcertify'>Certify</button></td>";

                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen</td>";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }

                if ($row->result_type == 'A')
                {
                    echo "<tr>";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td><label class='label label-warning'>$row->order_service</label><label class=' text-info'>  &nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td>$row->normal_range_from</td>";

                    echo "<td>$row->normal_range_to</td>";

                    echo "<td id='alphanormal' class='hidden'>$row->alpha_normal</td>";

                    echo "<td>$row->unit</td>";

                    echo " <td class='center'> <select id='method' name='method' class='input-sm' style='width: 100px'> ";

                    foreach ($method as $row1)
                    {
                        if ($row1->id == $row->method_id)
                        {
                            echo "<option value='$row1->id' selected> $row1->name</option>";
                        }
                        else
                        {
                            echo "<option value='$row1->id'> $row1->name</option>";
                        }
                    }

                    echo "</select></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    if ($row->alpha_result != $row->alpha_normal)
                    {
                        echo
                        "<td><input type='text' id='alpharesult' name='alpharesult' value='$row->alpha_result' class='input-sm highlightred'></td>";
                    }
                    else
                    {
                        echo
                        "<td><input type='text' id='alpharesult' name='alpharesult' value='$row->alpha_result' class='input-sm highlightgreen'></td>";
                    }

                    echo "<td><button class='btn btn-xs btn-primary' id='alphacertify' >Certify</button></td>";

                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen</td>";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }

                if ($row->result_type == 'R')
                {
                    echo "<tr >";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td><label class='label label-warning'>$row->order_service</label><label class=' text-info'>  &nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td></td>";

                    echo "<td></td>";

                    echo "<td id='alphanormal' class='hidden'></td>";

                    echo "<td></td>";

                    echo " <td></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    echo "<td><a class='btn btn-sm btn-primary' id='viewreport'>View Report</a></td>";

                    echo "<td></td>";

                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }
            }
        }

        if ($status == 4)
        {
            if ($this->input->post('labno'))
            {
                $result = $this->resultprocessing->search_labno_status4($labno, $frmdate, $todate);
            }
            else
            {
                $result = $this->resultprocessing->search_date_status4($frmdate, $todate);
            }

            foreach ($result as $row)
            {
                if ($row->result_type == 'N')
                {
                    echo "<tr>";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td><label class='label label-warning'>$row->order_service</label><label class=' text-info'>  &nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td>$row->normal_range_from</td>";

                    echo "<td>$row->normal_range_to</td>";

                    echo "<td id='alphanormal' class='hidden'>$row->alpha_normal</td>";

                    echo "<td>$row->unit</td>";

                    echo " <td class='center'> <select id='method' name='method' class='input-sm' style='width: 100px'> ";

                    foreach ($method as $row1)
                    {
                        if ($row1->id == $row->method_id)
                        {
                            echo "<option value='$row1->id' selected> $row1->name</option>";
                        }
                        else
                        {
                            echo "<option value='$row1->id'> $row1->name</option>";
                        }
                    }

                    echo "</select></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }
                    if ($row->numeric_result < $row->normal_range_from )
                    {
                        echo
                        "<td><input type='number' name='numresult' id='numresult' class='input-sm highlightblue' style='width: 100px' value='$row->numeric_result' ></td>";
                    }
                    elseif($row->numeric_result > $row->normal_range_to)
                    {
                        echo
                        "<td><input type='number' name='numresult' id='numresult' class='input-sm highlightred' style='width: 100px' value='$row->numeric_result' ></td>";
                    }
                    else
                    {
                        echo
                        "<td><input type='number' name='numresult' id='numresult' class='input-sm highlightgreen' style='width: 100px' value='$row->numeric_result' ></td>";
                    }
                    if (!$role['admin'] && !$role['labmanager'])
                    {
                        echo "<td></td>";
                    }
                    else
                    {
                        echo "<td><button type='button' class='btn btn-warning btn-xs' id='numrectify'>Rectify</button></td>";
                    }


                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen</td>";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }

                if ($row->result_type == 'A')
                {
                    echo "<tr>";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td><label class='text-warning'>$row->order_service</label><label class=' text-info'> ...$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td>$row->normal_range_from</td>";

                    echo "<td>$row->normal_range_to</td>";

                    echo "<td id='alphanormal' class='hidden'>$row->alpha_normal</td>";

                    echo "<td>$row->unit</td>";

                    echo " <td class='center'> <select id='method' name='method' class='input-sm' style='width: 100px'> ";

                    foreach ($method as $row1)
                    {
                        if ($row1->id == $row->method_id)
                        {
                            echo "<option value='$row1->id' selected> $row1->name</option>";
                        }
                        else
                        {
                            echo "<option value='$row1->id'> $row1->name</option>";
                        }
                    }

                    echo "</select></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    if ($row->alpha_result != $row->alpha_normal)
                    {
                        echo
                        "<td><input type='text' id='alpharesult' name='alpharesult' value='$row->alpha_result' class='input-sm highlightred' ></td>";
                    }
                    else
                    {
                        echo
                        "<td><input type='text' id='alpharesult' name='alpharesult' value='$row->alpha_result' class='input-sm highlightgreen' ></td>";
                    }
                    if (!$role['admin'] && !$role['labmanager'])
                    {
                        echo "<td></td>";
                    }
                    else
                    {
                        echo "<td><button class='btn btn-xs btn-warning' id='alpharectify' >Rectify</button></td>";
                    }


                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen</td>";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }

                if ($row->result_type == 'R')
                {
                    echo "<tr >";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td><label class='label label-warning'>$row->order_service</label><label class=' text-info'>  &nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td></td>";

                    echo "<td></td>";

                    echo "<td id='alphanormal' class='hidden'></td>";

                    echo "<td></td>";

                    echo " <td></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    echo "<td><a class='btn btn-sm btn-primary' id='viewreport'>View Report</a></td>";
                    if (!$role['admin'] && !$role['labmanager'])
                    {
                        echo "<td></td>";
                    }
                    else {

                        echo "<td><a class='btn btn-sm btn-primary' id='ammendreport'>Ammend Report</a></td>";
                    }

                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }
            }
        }

        if ($status == 5)
        {
            if ($this->input->post('labno'))
            {
                $result = $this->resultprocessing->search_labno_status5($labno, $frmdate, $todate);
            }
            else
            {
                $result = $this->resultprocessing->search_date_status5($frmdate, $todate);
            }

            foreach ($result as $row)
            {
                if ($row->result_type == 'N')
                {
                    echo "<tr>";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td><label class='label label-warning'>$row->order_service</label><label class=' text-info'>  &nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td>$row->normal_range_from</td>";

                    echo "<td>$row->normal_range_to</td>";

                    echo "<td id='alphanormal' class='hidden'>$row->alpha_normal</td>";

                    echo "<td>$row->unit</td>";

                    echo " <td class='center'> <select id='method' name='method' class='input-sm' style='width: 100px'> ";

                    foreach ($method as $row1)
                    {
                        if ($row1->id == $row->method_id)
                        {
                            echo "<option value='$row1->id' selected> $row1->name</option>";
                        }
                        else
                        {
                            echo "<option value='$row1->id'> $row1->name</option>";
                        }
                    }

                    echo "</select></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    if ($row->numeric_result < $row->normal_range_from )
                    {
                        echo
                        "<td><input type='number' name='numresult' id='numresult' class='input-sm highlightblue' style='width: 100px' value='$row->numeric_result' ></td>";
                    }
                    elseif($row->numeric_result > $row->normal_range_to)
                    {
                        echo
                        "<td><input type='number' name='numresult' id='numresult' class='input-sm highlightred' style='width: 100px' value='$row->numeric_result' ></td>";
                    }
                    else
                    {
                        echo
                        "<td><input type='number' name='numresult' id='numresult' class='input-sm highlightgreen' style='width: 100px' value='$row->numeric_result' ></td>";
                    }
                    
                    if (!$role['admin'] && !$role['labmanager'])
                    {
                        echo "<td></td>";
                    }
                    else
                    {
                        echo "<td><button type='button' class='btn btn-warning btn-xs' id='numrectify'>Rectify</button></td>";
                    }


                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen</td>";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }

                if ($row->result_type == 'A')
                {
                    echo "<tr>";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td><label class='label label-warning'>$row->order_service</label><label class=' text-info'>  &nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td>$row->normal_range_from</td>";

                    echo "<td>$row->normal_range_to</td>";

                    echo "<td id='alphanormal' class='hidden'>$row->alpha_normal</td>";

                    echo "<td>$row->unit</td>";

                    echo "<td class='center'> <select id='method' name='method' class='input-sm' style='width: 100px'> ";

                    foreach ($method as $row1)
                    {
                        if ($row1->id == $row->method_id)
                        {
                            echo "<option value='$row1->id' selected> $row1->name</option>";
                        }
                        else
                        {
                            echo "<option value='$row1->id'> $row1->name</option>";
                        }
                    }

                    echo "</select></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    if ($row->alpha_result != $row->alpha_normal)
                    {
                        echo
                        "<td><input type='text' id='alpharesult' name='alpharesult' value='$row->alpha_result' class='input-sm highlightred' ></td>";
                    }
                    else
                    {
                        echo
                        "<td><input type='text' id='alpharesult' name='alpharesult' value='$row->alpha_result' class='input-sm highlightgreen' disabled></td>";
                    }
                    if (!$role['admin'] && !$role['labmanager'])
                    {
                        echo "<td></td>";
                    }
                    else{
                        echo "<td><button class='btn btn-xs btn-warning' id='alpharectify' >Rectify</button></td>";
                    }



                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen</td>";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }

                if ($row->result_type == 'R')
                {
                    echo "<tr >";

                    echo "<td>$row->patient_name</td>";

                    echo "<td ><label class='label label-primary'>$row->labno</label></td>";

                    if ($row->panel_yesno == 1)
                    {
                        echo
                        "<td><label class='label label-warning'>$row->order_service</label><label class=' text-info'>  &nbsp;$row->lab_service </label></td>";
                    }
                    else
                    {
                        echo "<td><label class=' text-info'>$row->lab_service</label></td>";
                    }

                    echo "<td class='hidden'>$row->lab_order_id</td>";

                    echo "<td><a id='sampleid' <label class='label label-success'>$row->sample_id</label></a></td>";

                    echo "<td></td>";

                    echo "<td></td>";

                    echo "<td id='alphanormal' class='hidden'></td>";

                    echo "<td></td>";

                    echo " <td></td>";

                    if ($row->priority != 'High')
                    {
                        echo "<td><label class='label label-success'>$row->priority</label></td>";
                    }
                    else
                    {
                        echo "<td><label class='label label-danger'>$row->priority</label></td>";
                    }

                    echo "<td><a class='btn btn-xs btn-primary' id='viewreport'>View Report</a></td>";
                    if (!$role['admin'] && !$role['labmanager'])
                    {
                        echo "<td></td>";
                    }
                    else {

                        echo "<td><a class='btn btn-xs btn-primary' id='ammendreport'>Ammend Report</a></td>";
                    }

                    echo "<td><label class='label label-info'>$row->status</label></td>";

                    echo "<td>$row->specimen";

                    echo "<td>$row->container</td>";

                    echo "<td>$row->ordered_date_time</td>";

                    echo "<td>$row->ordered_by</td>";

                    echo "<td>$row->received_date_time</td>";

                    echo "<td>$row->received_by</td>";

                    echo "<td>$row->saved_date_time</td>";

                    echo "<td>$row->saved_by</td>";

                    echo "<td>$row->certified_date_time</td>";

                    echo "<td>$row->certified_by</td>";

                    echo "<td>$row->rectified_date_time</td>";

                    echo "<td>$row->rectified_by</td>";

                    echo "</tr>";
                }
            }
        }
    }

    public function save_numeric_result()
    {
        $orderid = $this->input->post('orderid');
        $result = $this->input->post('result');
        $user = $this->session->userdata('logged_in');
        $method=$this->input->post('method');
        $data = array
        (
            "status" => 3,
            "numeric_result" => $result,
            "saved_by" => $user['username'],
            "saved_date_time" => date('Y-m-d H:i:s'),
            "method_id" => $method
        );

        $return = $this->resultprocessing->update_result($data, $orderid);

        if ($return)
        {
            $response = array ("status" => true);

            echo json_encode($response);
        }
        else
        {
            $response = array ("status" => false);

            echo json_encode($response);
        }
    }

    public function certify_numeric_result()
    {
        $orderid = $this->input->post('orderid');
        $result = $this->input->post('result');
        $user = $this->session->userdata('logged_in');
        $method=$this->input->post('method');
        $data = array
        (
            "status" => 4,
            "numeric_result" => $result,
            "certified_by" => $user['username'],
            "certified_date_time" => date('Y-m-d H:i:s'),
            "method_id"=>$method
        );

        $return = $this->resultprocessing->update_result($data, $orderid);

        if ($return)
        {
            $data = array ("order_status" => 3);
            $service_order_id = $this->service_order->getdetails($orderid);

            foreach ($service_order_id as $row)
            {
                $this->service_order->update($data, $row->service_order_id);
            }
            $response = array ("status" => true);

            echo json_encode($response);
        }
        else
        {
            $response = array ("status" => false);

            echo json_encode($response);
        }
    }

    public function rectify_numeric_result()
    {
        $orderid = $this->input->post('orderid');
        $result = $this->input->post('result');
        $user = $this->session->userdata('logged_in');
        $method=$this->input->post('method');
        $data = array
        (
            "status" => 5,
            "numeric_result" => $result,
            "rectified_by" => $user['username'],
            "rectified_date_time" => date('Y-m-d H:i:s'),
            "method_id"=>$method
        );

        $return = $this->resultprocessing->update_result($data, $orderid);

        if ($return)
        {
            $response = array ("status" => true);

            echo json_encode($response);
        }
        else
        {
            $response = array ("status" => false);

            echo json_encode($response);
        }
    }

    public function save_alpha_result()
    {
        $orderid = $this->input->post('orderid');
        $result = $this->input->post('result');
        $user = $this->session->userdata('logged_in');
        $method=$this->input->post('method');
        $data = array
        (
            "status" => 3,
            "alpha_result" => $result,
            "saved_by" => $user['username'],
            "saved_date_time" => date('Y-m-d H:i:s'),
            "method_id"=>$method
        );

        $return = $this->resultprocessing->update_result($data, $orderid);

        if ($return)
        {
            $response = array ("status" => true);

            echo json_encode($response);
        }
        else
        {
            $response = array ("status" => false);

            echo json_encode($response);
        }
    }

    public function certify_alpha_result()
    {
        $orderid = $this->input->post('orderid');
        $result = $this->input->post('result');
        $user = $this->session->userdata('logged_in');
        $method=$this->input->post('method');
        $data = array
        (
            "status" => 4,
            "alpha_result" => $result,
            "certified_by" => $user['username'],
            "certified_date_time" => date('Y-m-d H:i:s'),
            "method_id"=>$method
        );

        $this->load->model('resultprocessing');
        $return = $this->resultprocessing->update_result($data, $orderid);

        if ($return)
        {
            $data = array ("order_status" => 3);
            $service_order_id = $this->service_order->getdetails($orderid);

            foreach ($service_order_id as $row)
            {
                $this->service_order->update($data, $row->service_order_id);
            }
            $response = array ("status" => true);

            echo json_encode($response);
        }
        else
        {
            $response = array ("status" => false);

            echo json_encode($response);
        }
    }

    public function rectify_alpha_result()
    {
        $orderid = $this->input->post('orderid');
        $result = $this->input->post('result');
        $user = $this->session->userdata('logged_in');
        $method=$this->input->post('method');
        $data = array
        (
            "status" => 5,
            "alpha_result" => $result,
            "rectified_by" => $user['username'],
            "rectified_date_time" => date('Y-m-d H:i:s'),
            "method_id"=>$method
        );

        $return = $this->resultprocessing->update_result($data, $orderid);

        if ($return)
        {
            $response = array ("status" => true);

            echo json_encode($response);
        }
        else
        {
            $response = array ("status" => false);

            echo json_encode($response);
        }
    }
}