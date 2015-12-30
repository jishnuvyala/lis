<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 23-11-2015
 * Time: 14:10
 */

class Service_order extends CI_Model
{

    public function getdetails($id)
    {
        $sql="select service_order_id from lab_orders where id=?";
        $query=$this->db->query($sql,array($id));
        return $query->result();

    }

    public function update($data,$id)

    {
        $this->db->where('id',$id);
        $this->db->update('service_order',$data);

    }



}