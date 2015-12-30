<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 11-11-2015
 * Time: 12:33
 */
class Sample_collection extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //checking user is logged in or not
        if(!$this->session->userdata('logged_in'))
        {
            redirect ('login','refresh');
        }
        if(!$this->session->userdata('role'))
        {
            redirect ('login','refresh');
        }
        $role=$this->session->userdata('role');
        //checking the user is billing staff/admin or not
        if(!$role['labuser']  && !$role['labmanager'] && !$role['admin'])
        {
            show_error('You are not autherized for this action.Please contact System Support' );
        }

        $this->load->helper('date');
        $this->load->model('collectionview');
        $this->load->model('service_order');

    }
    public function index()
    {

        $data['order']=$this->collectionview->order_details();
        $data['specimen']=$this->collectionview->specimen();
        $data['container']=$this->collectionview->container();
        $this->load->view('lab/collectsample',$data);
    }

    public function search()
    {

        $labno=$this->input->post('labno');
        $frmdate=$this->input->post('frmdate');
        $todate=$this->input->post('todate');
        $specimen=$this->collectionview->specimen();
        $container=$this->collectionview->container();

        if ($this->input->post('labno')) {
            $result = $this->collectionview->search_labno($labno, $frmdate, $todate);
        } else {
            $result = $this->collectionview->search_date($frmdate, $todate);
        }
        foreach($result as $row)
        {

            echo "<tr id='tablerow'>";
            echo "<td>$row->patient_name</td>";
            echo "<td><label class='label label-primary' >$row->labno</label> </td>";
            if($row->panel_yesno==1)
            {
                echo "<td><label class='label label-warning'>$row->order_service</label> <label class=' text-primary' >&nbsp;$row->lab_service </label></td>";

            }
            else{
                echo "<td><label class=' text-primary'>$row->lab_service</label></td>";
            }
            echo "<td class='hidden'>$row->order_id</td>";
            echo "<td class='hidden'>$row->lab_order_id</td>";
            echo " <td class='center'> <select id='specimen' name='specimen' class='input-sm' style='width: 100px'> ";
            foreach($specimen as $row1)
            {
                if($row1->id==$row->specimen_id){
             echo "<option value='$row1->id' selected> $row1->name</option>";
                }
                else
                {
                    echo "<option value='$row1->id'> $row1->name</option>";
                }

            }
            echo "</select></td>";

            echo " <td class='center'> <select id='container' name='container' class='input-sm' style='width: 100px'>";
            foreach($container as $row2)
            {
                if($row2->id==$row->container_id){
                    echo "<option value='$row2->id' selected> $row2->name</option>";
                }
                else
                {
                    echo "<option value='$row2->id'> $row2->name</option>";
                }

            }
            echo "</select></td>";
            echo "<td><select id='priority' class='input-sm'><option value='Low'>Low</option><option value='High'>High</option></select></td>";
            echo "<td>$row->ordered_date_time</td>";
            echo "<td>$row->ordered_by</td>";
            echo "<td><label class='label label-info'>$row->status</label></td>";
            echo "<td>$row->category</td>";
            echo "<td id='tablebutton'><button id='collect' name='register' class='btn btn-xs btn-success collect' >Collect Sample</button></td>";
            echo "</tr>";

        }

    }

    public function update()
    {
        $id=$this->input->post('id');
        $specimen_id=$this->input->post('specimen_id');
        $container=$this->input->post('container_id');
        $priority=$this->input->post('priority');
        $user=$this->session->userdata['logged_in'];
        $date= date('Ymd');
        $time= date('Hi');
        $digits = 4;
        $rand= rand(pow(10, $digits-1), pow(10, $digits)-1);
        $sampleid=$date.$time.$rand;
        $data=array(
            "status"=>2,
            "specimen_id"=>$specimen_id,
            "container_id"=>$container,
            "received_by"=>$user['username'],
            "received_date_time"=>date('Y-m-d H:i:s'),
            "sample_id"=>$sampleid,
            "priority"=>$priority
        );
        $return=$this->collectionview->update_status($data,$id);
        if($return)
        {
            $data=array(
                "order_status"=>2
            );
            $service_order_id=$this->service_order->getdetails($id);
            foreach($service_order_id as $row)
            {
                $this->service_order->update($data,$row->service_order_id);
            }

            $response=array(
                'status'=>true,
                'sample_id'=>$sampleid
            );
            echo json_encode($response);
        }
        else{

            $response=array(
                'status'=>false
            );
            echo json_encode($response);
        }




    }

}