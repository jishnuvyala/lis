<?php

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 23-11-2015
 * Time: 14:00
 */
class Cancelbrowser_model extends CI_Model
{

    public function search1($frmdate,$todate)
    {

     $sql="SELECT sm.name AS service,so.order_created_by ,so.ordered_date_time,so.refund_yesno,CONCAT(p.first_name,' ',p.last_name) AS patient,p.id AS labno,so.cancelled_by,so.cancelled_date_time,so.cancellation_remarks
       FROM service_order so
LEFT JOIN service_master sm ON sm.id=so.service_id
LEFT JOIN patient p ON p.id=so.patient_id
WHERE so.order_status=4 AND CAST(so.ordered_date_time AS DATE) BETWEEN ? AND ?  AND refund_yesno=0";
        $query=$this->db->query($sql,array($frmdate,$todate));
        return $query->result();

    }
    public function search2($labno,$frmdate,$todate)
    {

        $sql="SELECT sm.name AS service,so.order_created_by ,so.ordered_date_time,so.refund_yesno,CONCAT(p.first_name,' ',p.last_name) AS patient,p.id AS labno,so.cancelled_by,so.cancelled_date_time,so.cancellation_remarks
             FROM service_order so
           LEFT JOIN service_master sm ON sm.id=so.service_id
LEFT JOIN patient p ON p.id=so.patient_id
WHERE so.order_status=4 AND CAST(so.ordered_date_time AS DATE) BETWEEN ? AND ? AND so.patient_id=? ";
        $query=$this->db->query($sql,array($frmdate,$todate,$labno));
        return $query->result();

    }
    public function search3($labno,$frmdate,$todate)
    {

        $sql="SELECT sm.name AS service,so.order_created_by ,so.ordered_date_time,so.refund_yesno,CONCAT(p.first_name,' ',p.last_name) AS patient,p.id AS labno,so.cancelled_by,so.cancelled_date_time,so.cancellation_remarks
FROM service_order so
LEFT JOIN service_master sm ON sm.id=so.service_id
LEFT JOIN patient p ON p.id=so.patient_id
WHERE so.order_status=4 AND CAST(so.ordered_date_time AS DATE) BETWEEN ? AND ? AND so.patient_id=? AND refund_yesno=0
";
        $query=$this->db->query($sql,array($frmdate,$todate,$labno));
        return $query->result();

    }
    public function search4($frmdate,$todate)
    {

        $sql="SELECT sm.name AS service,so.order_created_by ,so.ordered_date_time,so.refund_yesno,CONCAT(p.first_name,' ',p.last_name) AS patient,p.id AS labno,so.cancelled_by,so.cancelled_date_time,so.cancellation_remarks
FROM service_order so
LEFT JOIN service_master sm ON sm.id=so.service_id
LEFT JOIN patient p ON p.id=so.patient_id
WHERE so.order_status=4 AND CAST(so.ordered_date_time AS DATE) BETWEEN ? AND ?
";
        $query=$this->db->query($sql,array($frmdate,$todate));
        return $query->result();

    }



}