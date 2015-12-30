<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 23-12-2015
 * Time: 14:35
 */

class Report_Model extends CI_Model
{

    public function get_details($id)
    {
        $sql="SELECT CONCAT(p.first_name,' ',p.last_name) AS patient_name,p.id AS labno,p.age AS age ,
            ls.name AS result_status,sm.name AS service,lo.id as order_id from lab_orders lo
            LEFT JOIN service_master sm ON sm.id=lo.service_id
            LEFT JOIN patient p ON lo.patient_id = p.id
            LEFT JOIN lab_order_status ls ON ls.id=lo.status
            WHERE lo.id=? LIMIT 1";
           $query=$this->db->query($sql,array($id));
           return $query->result();

    }
    public function update_status($orderid,$data)
    {
        $this->db->where('id',$orderid);
        $this->db->update('lab_orders',$data);

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
    public function report_name($id)
    {
        $this->db->select('report_name');
        $this->db->where('id',$id);
        $query=$this->db->get('lab_orders');
        return $query->result();
    }
    public function get_template()
    {
        $this->db->select('id,name');
        $this->db->where('active_yesno',1);
        $query=$this->db->get('template_master');
        return $query->result();
    }
    public function template_details($id)
    {
        $this->db->select('filename');
        $this->db->where('id',$id);
        $query=$this->db->get('template_master');
        return $query->result();
    }
}