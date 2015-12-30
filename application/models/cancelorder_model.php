<?php

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 23-11-2015
 * Time: 14:00
 */
class Cancelorder_model extends CI_Model
{

    public function search_status1($labno,$frmdate,$todate)
    {

     $sql="select sm.name as service,os.name as status,so.order_status,so.panel_yesno,so.order_created_by,so.ordered_date_time,concat(p.first_name,' ',p.last_name) as patient,p.id as labno,so.id as service_orderid from service_order so
      LEFT JOIN service_master sm on so.service_id=sm.id
      LEFT JOIN order_status os on os.id=so.order_status
      left join patient p on p.id=so.patient_id
      where so.patient_id=? and so.order_status=1 and cast(so.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY so.id ASC";
        $query=$this->db->query($sql,array($labno,$frmdate,$todate));
        return $query->result();

    }
    public function search_status2($labno,$frmdate,$todate)
    {

        $sql="select sm.name as service,os.name as status,so.order_status,so.panel_yesno,so.order_created_by,so.ordered_date_time,concat(p.first_name,' ',p.last_name) as patient,p.id as labno,so.id as service_orderid from service_order so
        LEFT JOIN service_master sm on so.service_id=sm.id
       LEFT JOIN order_status os on os.id=so.order_status
       left join patient p on p.id=so.patient_id
       where so.patient_id=? and so.order_status=2 and cast(so.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY so.id ASC";
        $query=$this->db->query($sql,array($labno,$frmdate,$todate));
        return $query->result();

    }
    public function search_statusboth($labno,$frmdate,$todate)
    {

        $sql="select sm.name as service,os.name as status,so.order_created_by,so.order_status,so.panel_yesno,so.ordered_date_time,concat(p.first_name,' ',p.last_name) as patient,p.id as labno,so.id as service_orderid from service_order so
        LEFT JOIN service_master sm on so.service_id=sm.id
        LEFT JOIN order_status os on os.id=so.order_status
        left join patient p on p.id=so.patient_id
        where so.order_status in(1,2) and  so.patient_id=? and cast(so.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY so.id ASC";
        $query=$this->db->query($sql,array($labno,$frmdate,$todate));
        return $query->result();

    }
    public function cancel_update($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('service_order', $data);

// was there any update or error?
        if ($this->db->affected_rows() == '1') {
            return true;
        } else {
            // any trans error?

            return false;


        }
    }
    public function laborder_update($data,$id)
    {
        $this->db->where('service_order_id', $id);
        $this->db->update('lab_orders', $data);

// was there any update or error?
        if ($this->db->affected_rows() <= '1') {
            return true;
        } else {
            // any trans error?

            return false;


        }
    }

}