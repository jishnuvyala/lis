<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 03-11-2015
 * Time: 20:06
 */
class Bill extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login', 'refresh');
        }
        if (!$this->session->userdata('role')) {
            redirect('login', 'refresh');
        }
        $role = $this->session->userdata('role');
        //checking the user is billing staff/admin or not
        if (!$role['billing'] && !$role['admin']) {
            show_error('You are not autherized for this action.Please contact System Support');
        }

        $this->load->model('billview_ajax');
        $this->load->model('bill_view');
        $this->load->helper('date');


    }

    //Showing the billing page with service data
    public function index()
    {
        $data['service'] = $this->bill_view->service_view();
        $this->load->view('bill/bill', $data);
    }

    //Patient details on tab out
    public function patient_details()
    {
        if ($this->input->post('id')) {


            $id = $this->input->post('id');
            $data = $this->billview_ajax->patient_view($id);
            foreach ($data as $row) {
                $response = array(
                    "name" => $row->name,
                    "age" => $row->age,
                    "phone_no" => $row->phone_no,
                    "status" => true);

            }
            echo json_encode($response);
        }

    }

    //Service price on service selection
    public function service_details()
    {
        if ($this->input->post('name')) {


            $name = $this->input->post('name');

            $getid = $this->billview_ajax->get_serviceid($name);
            foreach ($getid as $row) {
                $id = $row->id;
            }
            $panel_yesno = $this->billview_ajax->panel_yesno($id);
            if ($panel_yesno) {

                $mapping = $this->billview_ajax->panel_check($id);
                if ($mapping) {
                    $data = $this->billview_ajax->service_view($id);
                    foreach ($data as $row) {
                        $response['price'] = $row->price;
                        $response['check'] = true;
                    }
                    echo json_encode($response);
                } else {
                    $response['check'] = false;
                    echo json_encode($response);
                }

            } else {
                $data = $this->billview_ajax->service_view($id);
                foreach ($data as $row) {
                    $response['price'] = $row->price;
                    $response['check'] = true;
                }
                echo json_encode($response);
            }
        }

    }

    //Entering Bill Data
    public function add_bill()

    {
        if ($this->input->post('patientid')) {
            $total_amount = $this->input->post('totalamt');
            $paid_amount = $this->input->post('paidamt');

            if ($paid_amount < $total_amount) {
                $payment_status = 2;
            } else {
                $payment_status = 1;
            }
            $this->load->helper('date');
            $date = date('Y-m-d');
            $digits = 3;
            $rand = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $bill_no = $date . '-' . $rand;
            $user=$this->session->userdata('logged_in');

            $data = array(
                "bill_amount" => $this->input->post('billamt'),
                "discount_percentage" => $this->input->post('disc'),
                "total_amount" => $total_amount,
                "paid_amount" => $paid_amount,
                "patient_id" => $this->input->post('patientid'),
                "created_date" => date('Y-m-d H:i:s'),
                "created_by"=>$user['username'],
                "payment_status" => $payment_status,
                "bill_no" => $bill_no
            );
            //saving the bill into bill table
            $billreturn = $this->billview_ajax->new_bill($data);
            if ($billreturn) { //Saving data into bill_details
                $servicename = json_decode(stripslashes($this->input->post('servicearray')));
                $serviceqnty = json_decode(stripslashes($this->input->post('qntyarray')));
                $serviceprice = json_decode(stripslashes($this->input->post('pricearray')));
                foreach ($servicename as $index => $code) {
                    $service_details = $this->billview_ajax->service_idview($code);
                    foreach ($service_details as $row) {
                        $servicecode = $row->id;
                        $panel_yesno = $row->panel_yesno;
                        $data = array(
                            "service_id" => $servicecode,
                            "quantity" => $serviceqnty[$index],
                            "total_price" => $serviceprice[$index],
                            "bill_id" => $billreturn,
                            "date_time" => date('Y-m-d H:i:s')
                        );
                        $billorder_return = $this->billview_ajax->bill_details($data);

                    }//End of Bill return check
                }


            } else {

                $response['status'] = false;
                echo json_encode($response);
            }
            if (!$billorder_return) {
                $response['status'] = false;
                echo json_encode($response);
            } else { //Data for service order table
                $user = $this->session->userdata('logged_in');
                $billdetails = $this->billview_ajax->billdetails_view($billreturn);

                foreach ($billdetails as $row) {

                    $servicedata = array(
                        "service_id" => $row->service_id,
                        "panel_yesno" => $row->panel_yesno,
                        "bill_id" => $billreturn,
                        "patient_id" => $row->patient_id,
                        "order_status" => 1,
                        "order_created_by" => $user['username'],
                        "ordered_date_time" => date('Y-m-d H:i:s')
                    );
                    $count = 1;
                    while ($count <= $row->quantity) {
                        $service_order = $this->billview_ajax->service_order($servicedata);
                        $count++;
                    }

                }

            }

            if (!$service_order) {
                $response['status'] = false;
                echo json_encode($response);
            } else {
                //Entering into Lab_orders
                $serviceorder = $this->billview_ajax->serviceorder_details($billreturn);
                foreach ($serviceorder as $row) {
                    if ($row->panel_yesno == 1) { //If Panel collecting panel mapping details and creating lab order
                        $paneldata = $this->billview_ajax->panel_services($row->service_id);
                        foreach ($paneldata as $row1) {
                            $data = array(
                                "service_id" => $row1->service_id,
                                "status" => 1,
                                "patient_id" => $row->patient_id,
                                "service_order_id" => $row->id,
                                "ordered_by"=>$user['username'],
                                "ordered_date_time" => date('Y-m-d H:i:s')
                            );
                            $laborder = $this->billview_ajax->lab_orders($data);
                            $result_type = $this->billview_ajax->result_type($row1->service_id);
                            foreach ($result_type as $row3) {
                                //If service is numerical updating normal ranges
                                if ($row3->result_type == 'N') {
                                    $range = $this->billview_ajax->result_range($row1->service_id);
                                    foreach ($range as $row4) {
                                        $data = array(
                                            "normal_range_from" => $row4->from_range,
                                            "normal_range_to" => $row4->to_range,
                                            "result_type" => $row3->result_type,
                                            "result_unit" => $row3->unit_id
                                        );
                                        $this->billview_ajax->update_range($data, $laborder);
                                    }
                                } else {
                                    $data = array("result_type" => $row3->result_type,
                                        "result_unit" => $row3->unit_id);
                                    $this->billview_ajax->update_range($data, $laborder);
                                }
                            }
                        }

                    } else {
                        $data = array(
                            "service_id" => $row->service_id,
                            "status" => 1,
                            "patient_id" => $row->patient_id,
                            "service_order_id" => $row->id,
                            "ordered_by"=>$user['username'],
                            "ordered_date_time" => date('Y-m-d H:i:s')
                        );
                        $laborder = $this->billview_ajax->lab_orders($data);
                        $result_type = $this->billview_ajax->result_type($row->service_id);
                        foreach ($result_type as $row3) {
                            if ($row3->result_type == 'N') {
                                $range = $this->billview_ajax->result_range($row->service_id);
                                foreach ($range as $row4) {
                                    $data = array(
                                        "normal_range_from" => $row4->from_range,
                                        "normal_range_to" => $row4->to_range,
                                        "result_type" => $row3->result_type,
                                        "result_unit" => $row3->unit_id
                                    );
                                    $this->billview_ajax->update_range($data, $laborder);
                                }
                            } else {
                                $data = array("result_type" => $row3->result_type,
                                    "result_unit" => $row3->unit_id);
                                $this->billview_ajax->update_range($data, $laborder);
                            }
                        }
                    }
                }

            }
            if (!$laborder) {
                $response['status'] = false;
                echo json_encode($response);

            } else {
                $response['status'] = true;
                $response['billid'] = $billreturn;
                $response['billno'] = $bill_no;
                echo json_encode($response);
            }


        } else {
            show_error("Opps!.");
        }
    }


}