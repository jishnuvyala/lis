<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 03-11-2015
 * Time: 20:06
 */
class Bill_ajax extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('billview_ajax');
        $this->load->helper('date');

    }

    public function patient_details()
    {
        $id = $this->input->post('id');
        $data = $this->billview_ajax->patient_view($id);
        foreach ($data as $row) {
            $response = array(
                "name" => $row->name,
                "age" => $row->age,
                "phone_no" => $row->phone_no,
                "status" => true
            );

        }
        echo json_encode($response);

    }

    public function service_details()
    {

        $keyword = $this->input->post('name');
        $data = $this->billview_ajax->service_view($keyword);
        foreach ($data as $row) {
            $response['price'] = $row->price;


        }
        echo json_encode($response);
    }

    public function add_bill()

    {  //Entering Bill Data

        $total_amount = $this->input->post('totalamt');
        $paid_amount = $this->input->post('paidamt');

        if ($paid_amount < $total_amount) {
            $payment_status = 2;
        } else {
            $payment_status = 1;
        }

        $data = array(
            "bill_amount" => $this->input->post('billamt'),
            "discount_percentage" => $this->input->post('disc'),
            "total_amount" => $total_amount,
            "paid_amount" => $paid_amount,
            "patient_id" => $this->input->post('patientid'),
            "created_date" => date('Y-m-d H:i:s'),
            "payment_status" => $payment_status
        );

        $billreturn = $this->billview_ajax->new_bill($data);
        if ($billreturn) {
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
        } else {
            $billdetails = $this->billview_ajax->billdetails_view($billreturn);

            foreach ($billdetails as $row) {

                $servicedata = array(
                    "service_id" => $row->service_id,
                    "panel_yesno" => $row->panel_yesno,
                    "bill_id" => $billreturn,
                    "patient_id" => $row->patient_id,
                    "order_status" => 1


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

            $serviceorder = $this->billview_ajax->serviceorder_details($billreturn);
            foreach ($serviceorder as $row) {
                if ($row->panel_yesno == 1) {
                    $paneldata = $this->billview_ajax->panel_services($row->service_id);
                    foreach ($paneldata as $row1) {
                        $data = array(
                            "service_id" => $row1->service_id,
                            "status" => 1,
                            "patient_id" => $row->patient_id,
                            "service_order_id" => $row->id,
                            "ordered_date_time" => date('Y-m-d H:i:s')
                        );
                        $laborder = $this->billview_ajax->lab_orders($data);
                        $result_type = $this->billview_ajax->result_type($row1->service_id);
                        foreach ($result_type as $row3) {
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
            echo json_encode($response);
        }


    }


}