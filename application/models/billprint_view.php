<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 10-11-2015
 * Time: 22:27
 */
class Billprint_view extends CI_Model
{

    public function bill_view($id)

    {

        $sql="select b.id,b.bill_no,b.bill_amount,b.discount_percentage,b.total_amount,b.paid_amount,b.created_by ,b.created_date,concat(p.first_name ,' ',p.last_name) as name,p.age,p.address,p.phone_no,p.email from bill b
        left join patient p on p.id=b.patient_id
        where b.id=? limit 1";
        $query=$this->db->query($sql,array($id));
        return $query->result();

    }

    public function billdetails_view($id)
    {

        $sql="select s.name as servicename,s.price,b.quantity,b.total_price from bill_details b
              left join service_master s on s.id=b.service_id where b.bill_id=? ";
        $query=$this->db->query($sql,array($id));
        return $query->result();

    }

    public function refund_bill($id)
    {
        $this->db->select('rf.bill_no,rf.total_amount,rf.created_by,rf.created_date_time,p.first_name,p.last_name,p.address,p.phone_no,p.id as labno,p.email');
        $this->db->from('refund_bill rf');
        $this->db->join('patient p','p.id=rf.patient_id','left');
        $this->db->where('rf.id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    public function refund_billdetails($id)
    {
        $this->db->select('s.name as servicename,s.price');
        $this->db->from('refund_details rf');
        $this->db->join('service_master s','s.id=rf.service_id','left');
        $this->db->where('rf.refund_bill_id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    public function company()
    {
        $query=$this->db->get('company');
        return $query->result();
    }
}