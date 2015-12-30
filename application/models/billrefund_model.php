<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 14-12-2015
 * Time: 18:29
 */
class Billrefund_model extends CI_Model
{
    public function check_patient($id)
    {
        $this->db->where('id',$id);
        $query=$this->db->get('patient');
        if($query->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function get_patient($id)
    {
        $sql="select concat(first_name,' ',last_name) as name,age,phone_no,email from patient where id=?";
        $query=$this->db->query($sql,array($id));
        return $query->result();
    }

    public function cancel_details($id)
    {
        $this->db->select('s.name,s.price,b.id as bill_id,s.id as service_id,so.id as order_id,b.bill_no');
        $this->db->from('service_order so');
        $this->db->join('service_master s','s.id=so.service_id','left');
        $this->db->join('bill b','b.id=so.bill_id','left');
        $this->db->where('so.patient_id',$id);
        $this->db->where('so.order_status',4);
        $this->db->where('so.refund_yesno !=',1);
        $query=$this->db->get();
        return $query->result();



    }
    public function bill($data)

    {
        $this->db->insert('refund_bill',$data);
        if($this->db->affected_rows()!=1)
        {
            return false;
        }
        else
        {
            $insert_id= $this->db->insert_id();
            return $insert_id;
        }

    }
    public function refund_details($data)

    {
        $this->db->insert('refund_details',$data);
        if($this->db->affected_rows()!=1)
        {
            return false;
        }
        else
        {

            return true;
        }

    }
    public function service_orderupdate($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('service_order',$data);

// was there any update or error?
        if ($this->db->affected_rows() == '1') {
            return true;
        } else {
            // any trans error?
            if ($this->db->trans_status() === FALSE) {
                return false;
            }
            return true;
        }
    }

}