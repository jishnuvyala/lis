<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 03-11-2015
 * Time: 20:10
 */
class Billview_ajax extends CI_Model
{
    public function patient_view($id)
    {

        $sql = "select concat(first_name,' ',last_name)as name ,age,phone_no from patient where id=? limit 1";
        $query = $this->db->query($sql, array($id));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }

    public function get_serviceid($name)
    {

        $this->db->select('id');
        $this->db->where('name', $name);
        $this->db->limit(1);
        $query = $this->db->get('service_master');
        return $query->result();
    }

    public function service_view($id)
    {

        $sql = "select price from service_master where id=? limit 1";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    public function panel_yesno($id)
    {
        $this->db->select('id');
        $this->db->where('id', $id);
        $this->db->where('panel_yesno', 1);
        $this->db->limit(1);
        $query = $this->db->get('service_master');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function panel_check($id)
    {
        $this->db->where('panel_id', $id);
        $query = $this->db->get('panel_service');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function new_bill($data)
    {
        $this->db->insert('bill', $data);

        if ($this->db->affected_rows() != 1) {
            return false;
        } else {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }


    public function bill_details($data)
    {
        $this->db->insert('bill_details', $data);

        if ($this->db->affected_rows() != 1) {
            return false;
        } else {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }

    public function lab_orders($data)
    {

        $this->db->set($data);
        $this->db->insert('lab_orders');
        if ($this->db->affected_rows() != 1) {
            return false;
        } else {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }


    public function service_idview($service)
    {

        $sql = "select id,panel_yesno from service_master where name=? limit 1";
        $query = $this->db->query($sql, array($service));
        return $query->result();
    }

    public function panel_services($service_id)
    {

        $sql = "select panel_id,service_id from panel_service where panel_id=?";
        $query = $this->db->query($sql, array($service_id));
        return $query->result();
    }

    public function service_order_details($id)
    {

        $sql = "select bd.service_id,bd.quantity,sm.panel_yesno,b.patient_id from bill_details bd
         left join service_master sm on bd.service_id=sm.id
         left join bill b on b.id=bd.bill_id
        where bd.id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    public function service_order($servicedata)
    {

        $this->db->set($servicedata);
        $this->db->insert('service_order');
        if ($this->db->affected_rows() != 1) {
            return false;
        } else {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }

    public function billdetails_view($id)
    {
        $sql = "select bd.*,sm.panel_yesno,bl.patient_id from bill_details bd
               left join service_master sm on bd.service_id=sm.id
               left join bill bl on bd.bill_id=bl.id
           where bd.bill_id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    public function serviceorder_details($id)
    {
        $sql = "select so.* from service_order so where so.bill_id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    public function result_type($id)
    {
        $sql = "select result_type,unit_id from service_master  where id=? limit 1";
        $query = $this->db->query($sql, array($id));
        return $query->result();

    }

    public function result_range($id)
    {
        $sql = "select from_range,to_range from service_numeric_results  where service_id=? limit 1";
        $query = $this->db->query($sql, array($id));
        return $query->result();

    }

    public function update_range($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('lab_orders', $data);
    }

}