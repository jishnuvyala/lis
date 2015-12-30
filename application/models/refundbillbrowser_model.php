<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 14-12-2015
 * Time: 12:11
 */
class Refundbillbrowser_model extends CI_Model
{

    public function search($frmdate,$todate)
    {
       $sql="select b.*,concat(p.first_name,' ',p.last_name) as patient,p.id as labno from refund_bill b
              left join patient p on p.id=b.patient_id
              where CAST(created_date_time AS DATE) between ? and ?";
        $query=$this->db->query($sql,array($frmdate,$todate));
        return $query->result();
    }
    public function search_labno($labno,$frmdate,$todate)
    {
        $sql="select b.*,concat(p.first_name,' ',p.last_name) as patient,p.id as labno from refund_bill b
              left join patient p on p.id=b.patient_id
              where CAST(created_date_time AS DATE) between ? and ? and b.patient_id=?";
        $query=$this->db->query($sql,array($frmdate,$todate,$labno));
        return $query->result();
    }
    public function search_billno($billno,$frmdate,$todate)
    {
        $sql="select b.*,concat(p.first_name,' ',p.last_name) as patient,p.id as labno from refund_bill b
              left join patient p on p.id=b.patient_id
             where CAST(created_date_time AS DATE) between ? and ? and b.bill_no like ?";
        $query=$this->db->query($sql,array($frmdate,$todate,$billno));
        return $query->result();
    }
    public function search_both($labno,$billno,$frmdate,$todate)
    {
        $sql="select b.*,concat(p.first_name,' ',p.last_name) as patient,p.id as labno from refund_bill b
              left join patient p on p.id=b.patient_id
              where CAST(created_date_time AS DATE) between ? and ? and  b.bill_no like ? and b.patient_id=?";
        $query=$this->db->query($sql,array($frmdate,$todate,$billno,$labno));
        return $query->result();
    }


}