<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 22-12-2015
 * Time: 15:43
 */
class Resultbrowser_model extends CI_Model
{

    public function search($labno,$frmdate,$todate)
    {
        $sql="SELECT CONCAT(p.first_name,' ',p.last_name) AS patient_name,p.id AS labno, sm2.name AS order_service,sm1.name AS lab_service,
   lo.alpha_result,lo.numeric_result,lo.certified_by,lo.certified_date_time,lo.rectified_by,lo.rectified_date_time,
            lo.normal_range_from,lo.normal_range_to,sn.alpha_normal,uo.name AS unit,lo.result_type,
            ls.name AS result_status,so.panel_yesno,lo.sample_id,m.name AS method ,lo.id as orderid FROM lab_orders lo
            LEFT JOIN service_order so  ON so.id=lo.service_order_id
            LEFT JOIN service_master sm1 ON sm1.id=lo.service_id
            LEFT JOIN service_master sm2 ON sm2.id=so.service_id
            LEFT JOIN patient p ON lo.patient_id = p.id
            LEFT JOIN lab_order_status ls ON ls.id=lo.status
            LEFT JOIN unit_master uo ON lo.result_unit=uo.id
            LEFT JOIN service_alpha_normal sn ON sn.service_id=sm1.id
            LEFT JOIN method_master m ON lo.method_id=m.id
            WHERE lo.status IN(4,5) AND p.id=? and cast(lo.ordered_date_time as DATE) BETWEEN ? and ?  ORDER BY lo.service_order_id ASC";
            $query=$this->db->query($sql,array($labno,$frmdate,$todate));
             return $query->result();
    }
    public function result_print ($labno,$frmdate,$todate)
    {
        $sql="SELECT  sm2.name AS order_service,sm1.name AS lab_service, lo.alpha_result,lo.numeric_result,lo.certified_by,lo.certified_date_time,lo.rectified_by,lo.rectified_date_time,
            lo.normal_range_from,lo.normal_range_to,sn.alpha_normal,uo.name AS unit,lo.result_type,ct.name as category,
            ls.name AS result_status,so.panel_yesno,lo.sample_id,m.name AS method ,lo.id as orderid FROM lab_orders lo
            LEFT JOIN service_order so  ON so.id=lo.service_order_id
            LEFT JOIN service_master sm1 ON sm1.id=lo.service_id
            LEFT JOIN service_master sm2 ON sm2.id=so.service_id
            LEFT JOIN lab_order_status ls ON ls.id=lo.status
            LEFT JOIN unit_master uo ON lo.result_unit=uo.id
            LEFT JOIN service_alpha_normal sn ON sn.service_id=sm1.id
            LEFT JOIN method_master m ON lo.method_id=m.id
            left join category_master ct on sm2.category_id=ct.id
            WHERE lo.status IN(4,5)  and cast(lo.ordered_date_time as DATE) BETWEEN ? and ?  and lo.result_type IN('A','N') and lo.patient_id=? ORDER BY lo.service_order_id ASC";
        $query=$this->db->query($sql,array($frmdate,$todate,$labno));
        return $query->result();
    }
    public function patient_info($labno)
    {
        $sql="SELECT CONCAT(p.first_name,' ',p.last_name) AS patient_name,p.age,p.address,p.phone_no,p.email,p.id as labno from patient p where id=?";
        $query=$this->db->query($sql,array($labno));
        return $query->result();

    }
}