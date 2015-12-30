<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 15-11-2015
 * Time: 15:01
 */

class Dashboard_view extends CI_Model
{
    public function qoutes()
    {
        $sql="SELECT qoute FROM qoutes order by rand() limit 1";
        $query=$this->db->query($sql);
        return $query->result();

    }
    public function total_collection($user)
    {
        $sql="SELECT SUM(paid_amount) as total FROM bill WHERE created_by=? AND CAST(created_date AS DATE) =CURDATE()";
        $query=$this->db->query($sql,array($user));
        return $query->result();
    }
    public function total_refund($user)
    {
        $sql="SELECT SUM(total_amount) AS refund FROM refund_bill WHERE created_by=? AND CAST(created_date_time AS DATE) =CURDATE()";
        $query=$this->db->query($sql,array($user));
        return $query->result();
    }
    public function total_cancel()
    {
        $this->db->where('order_status',4);
        $this->db->where('refund_yesno !=','1');
        $query=$this->db->get('service_order');
        return $query->num_rows();


    }
    public function total_reg($user)
    {
        $sql="SELECT * FROM patient WHERE last_modified_by=? AND CAST(last_modified_on AS DATE) =CURDATE()";
        $query=$this->db->query($sql,array($user));
        return $query->num_rows();
    }
    public function total_pending_collection()
    {
        $this->db->where('status',1);
        $query=$this->db->get('lab_orders');
        return $query->num_rows();


    }
    public function total_pending_saved()
    {
        $type = array('A', 'N');
        $this->db->where('status',2);
        $this->db->where_in('result_type',$type);
        $query=$this->db->get('lab_orders');
        return $query->num_rows();


    }
    public function total_pending_certify()
    {
        $this->db->where('status',4);
        $query=$this->db->get('lab_orders');
        return $query->num_rows();


    }
    public function total_pending_report()
    {
        $this->db->where('status',2);
        $this->db->where('result_type','R');
        $query=$this->db->get('lab_orders');
        return $query->num_rows();


    }

}