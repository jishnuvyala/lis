<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 11-11-2015
 * Time: 13:25
 */

class Collectionview extends CI_Model
{
    public function order_details()
    {
        $sql="select lo.service_order_id as order_id,sm2.name as order_service,sm1.name as lab_service,
    concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno,lo.id as lab_order_id,
    sp.name as specimen,sp.id as specimen_id,cm.id as container_id,lo.priority as priority,
    lo.ordered_by,lo.ordered_date_time,cm.name as container,ls.name as status,so.panel_yesno from lab_orders lo
    left join service_order so  on so.id=lo.service_order_id
    left join service_master sm1 on sm1.id=lo.service_id
    left join service_master sm2 on sm2.id=so.service_id
    left join patient p on lo.patient_id = p.id
    left join specimen_master sp on sp.id=sm1.specimen_id
    left join container_master cm on cm.id=sm1.container_id
    left join lab_order_status ls on ls.id=lo.status
    where lo.status=1 order by lo.service_order_id ASC";
        $query=$this->db->query($sql);
        return $query->result();
    }
    public function search_labno($labno,$frmdate,$todate)
    {
        $sql = "select lo.service_order_id as order_id,sm2.name as order_service,sm1.name as lab_service,
    concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno,lo.id as lab_order_id,
    sp.name as specimen,sp.id as specimen_id,cm.id as container_id,lo.priority as priority,
    lo.ordered_by,lo.ordered_date_time,cm.name as container,ls.name as status,so.panel_yesno,ct.name as category from lab_orders lo
    left join service_order so  on so.id=lo.service_order_id
    left join service_master sm1 on sm1.id=lo.service_id
    left join service_master sm2 on sm2.id=so.service_id
    left join patient p on lo.patient_id = p.id
    left join specimen_master sp on sp.id=sm1.specimen_id
    left join container_master cm on cm.id=sm1.container_id
    left join lab_order_status ls on ls.id=lo.status
    left join category_master ct on ct.id=sm1.category_id
    where CAST(lo.ordered_date_time  AS DATE) between ? and ? and lo.status=1 and lo.patient_id=? order by lo.service_order_id ASC";
        $query=$this->db->query($sql,array($frmdate,$todate,$labno));
        return $query->result();
    }
    public function search_date($frmdate,$todate)
    {
        $sql = "select lo.service_order_id as order_id,sm2.name as order_service,sm1.name as lab_service,
    concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno,lo.id as lab_order_id,
    sp.name as specimen,sp.id as specimen_id,cm.id as container_id,lo.priority as priority,
    lo.ordered_by,lo.ordered_date_time,cm.name as container,ls.name as status,so.panel_yesno,ct.name as category from lab_orders lo
    left join service_order so  on so.id=lo.service_order_id
    left join service_master sm1 on sm1.id=lo.service_id
    left join service_master sm2 on sm2.id=so.service_id
    left join patient p on lo.patient_id = p.id
    left join specimen_master sp on sp.id=sm1.specimen_id
    left join container_master cm on cm.id=sm1.container_id
    left join lab_order_status ls on ls.id=lo.status
    left join category_master ct on ct.id=sm1.category_id
    where CAST(lo.ordered_date_time AS DATE) between ? and ? and lo.status=1 order by lo.service_order_id ASC";
        $query=$this->db->query($sql,array($frmdate,$todate));
        return $query->result();
    }

    public function specimen()
    {
        $sql="select * from specimen_master where active_yesno=1";
        $query=$this->db->query($sql);
        return $query->result();

    }
    public function container()
    {
        $sql="select * from container_master where active_yesno=1";
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function update_status($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('lab_orders',$data);

// was there any update or error?
        if ($this->db->affected_rows() == '1') {
            return true;
        } else {
            // any trans error?

                return false;


        }

    }

}