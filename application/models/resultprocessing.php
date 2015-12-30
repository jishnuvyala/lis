<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 13-11-2015
 * Time: 11:32
 */

class Resultprocessing extends CI_Model
{

    public function search_date($frmdate,$todate)
    {

        $sql="select concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno, sm2.name as order_service,sm1.name as lab_service,lo.service_order_id as order_id,
            lo.id as lab_order_id,lo.certified_by,lo.certified_date_time,lo.rectified_by,lo.rectified_date_time,lo.saved_by,lo.saved_date_time,
            sp.name as specimen,lo.priority as priority,uo.name as unit,lo.result_type,lo.normal_range_from,lo.normal_range_to,sn.alpha_normal,
            lo.ordered_by,lo.ordered_date_time,lo.received_by,lo.received_date_time,cm.name as container,ls.name as status,so.panel_yesno,lo.sample_id,lo.method_id from lab_orders lo
            left join service_order so  on so.id=lo.service_order_id
            left join service_master sm1 on sm1.id=lo.service_id
            left join service_master sm2 on sm2.id=so.service_id
            left join patient p on lo.patient_id = p.id
            left join specimen_master sp on sp.id=lo.specimen_id
            left join container_master cm on cm.id=sm1.container_id
            left join lab_order_status ls on ls.id=lo.status
            left join unit_master uo on lo.result_unit=uo.id
            left join service_alpha_normal sn on sn.service_id=sm1.id
            where lo.status=2 and cast(lo.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY lo.service_order_id ASC ";
        $query=$this->db->query($sql,array($frmdate,$todate));
        return $query->result();

    }
    public function search_labno($labno,$frmdate,$todate)
    {

        $sql="select concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno, sm2.name as order_service,sm1.name as lab_service,lo.service_order_id as order_id,
            lo.id as lab_order_id,lo.certified_by,lo.certified_date_time,lo.rectified_by,lo.rectified_date_time,lo.saved_by,lo.saved_date_time,
            sp.name as specimen,lo.priority as priority,uo.name as unit,lo.result_type,lo.normal_range_from,lo.normal_range_to,sn.alpha_normal,
            lo.ordered_by,lo.ordered_date_time,lo.received_by,lo.received_date_time,cm.name as container,ls.name as status,so.panel_yesno,lo.sample_id,lo.method_id from lab_orders lo
            left join service_order so  on so.id=lo.service_order_id
            left join service_master sm1 on sm1.id=lo.service_id
            left join service_master sm2 on sm2.id=so.service_id
            left join patient p on lo.patient_id = p.id
            left join specimen_master sp on sp.id=lo.specimen_id
            left join container_master cm on cm.id=sm1.container_id
            left join lab_order_status ls on ls.id=lo.status
            left join unit_master uo on lo.result_unit=uo.id
            left join service_alpha_normal sn on sn.service_id=sm1.id
            where lo.status=2 and p.id=? and  cast(lo.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY lo.service_order_id ASC";
        $query=$this->db->query($sql,array($labno,$frmdate,$todate));
        return $query->result();

    }
    public function search_date_status3($frmdate,$todate)
    {

        $sql="select concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno, sm2.name as order_service,sm1.name as lab_service,lo.service_order_id as order_id,
            lo.id as lab_order_id,lo.alpha_result,lo.numeric_result,lo.report_name,lo.certified_by,lo.certified_date_time,lo.rectified_by,lo.rectified_date_time,lo.saved_by,lo.saved_date_time,
            sp.name as specimen,lo.priority as priority,uo.name as unit,lo.result_type,lo.normal_range_from,lo.normal_range_to,sn.alpha_normal,
            lo.ordered_by,lo.ordered_date_time,lo.received_by,lo.received_date_time,cm.name as container,ls.name as status,so.panel_yesno,lo.sample_id,lo.method_id from lab_orders lo
            left join service_order so  on so.id=lo.service_order_id
            left join service_master sm1 on sm1.id=lo.service_id
            left join service_master sm2 on sm2.id=so.service_id
            left join patient p on lo.patient_id = p.id
            left join specimen_master sp on sp.id=lo.specimen_id
            left join container_master cm on cm.id=sm1.container_id
            left join lab_order_status ls on ls.id=lo.status
            left join unit_master uo on lo.result_unit=uo.id
            left join service_alpha_normal sn on sn.service_id=sm1.id
            where lo.status=3 and  cast(lo.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY lo.service_order_id ASC";
        $query=$this->db->query($sql,array($frmdate,$todate));
        return $query->result();

    }
    public function search_labno_status3($labno,$frmdate,$todate)
    {

        $sql="select concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno, sm2.name as order_service,sm1.name as lab_service,lo.service_order_id as order_id,
            lo.id as lab_order_id,lo.alpha_result,lo.numeric_result,lo.report_name,lo.certified_by,lo.certified_date_time,lo.rectified_by,lo.rectified_date_time,lo.saved_by,lo.saved_date_time,
            sp.name as specimen,lo.priority as priority,uo.name as unit,lo.result_type,lo.normal_range_from,lo.normal_range_to,sn.alpha_normal,
            lo.ordered_by,lo.ordered_date_time,lo.received_by,lo.received_date_time,cm.name as container,ls.name as status,so.panel_yesno,lo.sample_id,lo.method_id from lab_orders lo
            left join service_order so  on so.id=lo.service_order_id
            left join service_master sm1 on sm1.id=lo.service_id
            left join service_master sm2 on sm2.id=so.service_id
            left join patient p on lo.patient_id = p.id
            left join specimen_master sp on sp.id=lo.specimen_id
            left join container_master cm on cm.id=sm1.container_id
            left join lab_order_status ls on ls.id=lo.status
            left join unit_master uo on lo.result_unit=uo.id
            left join service_alpha_normal sn on sn.service_id=sm1.id
            where lo.status=3 and p.id=? and  cast(lo.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY lo.service_order_id ASC";
        $query=$this->db->query($sql,array($labno,$frmdate,$todate));
        return $query->result();

    }
    public function search_date_status4($frmdate,$todate)
    {

        $sql="select concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno, sm2.name as order_service,sm1.name as lab_service,lo.service_order_id as order_id,
            lo.id as lab_order_id,lo.alpha_result,lo.numeric_result,lo.report_name,lo.certified_by,lo.certified_date_time,lo.rectified_by,lo.rectified_date_time,lo.saved_by,lo.saved_date_time,
            sp.name as specimen,lo.priority as priority,uo.name as unit,lo.result_type,lo.normal_range_from,lo.normal_range_to,sn.alpha_normal,
            lo.ordered_by,lo.ordered_date_time,lo.received_by,lo.received_date_time,cm.name as container,ls.name as status,so.panel_yesno,lo.sample_id,lo.method_id from lab_orders lo
            left join service_order so  on so.id=lo.service_order_id
            left join service_master sm1 on sm1.id=lo.service_id
            left join service_master sm2 on sm2.id=so.service_id
            left join patient p on lo.patient_id = p.id
            left join specimen_master sp on sp.id=lo.specimen_id
            left join container_master cm on cm.id=sm1.container_id
            left join lab_order_status ls on ls.id=lo.status
            left join unit_master uo on lo.result_unit=uo.id
            left join service_alpha_normal sn on sn.service_id=sm1.id
            where lo.status=4 and  cast(lo.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY lo.service_order_id ASC";
        $query=$this->db->query($sql,array($frmdate,$todate));
        return $query->result();

    }
    public function search_labno_status4($labno,$frmdate,$todate)
    {

        $sql="select concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno, sm2.name as order_service,sm1.name as lab_service,lo.service_order_id as order_id,
            lo.id as lab_order_id,lo.alpha_result,lo.numeric_result,lo.report_name,lo.certified_by,lo.certified_date_time,lo.rectified_by,lo.rectified_date_time,lo.saved_by,lo.saved_date_time,
            sp.name as specimen,lo.priority as priority,uo.name as unit,lo.result_type,lo.normal_range_from,lo.normal_range_to,sn.alpha_normal
            lo.ordered_by,lo.ordered_date_time,lo.received_by,lo.received_date_time,cm.name as container,ls.name as status,so.panel_yesno,lo.sample_id,lo.method_id from lab_orders lo
            left join service_order so  on so.id=lo.service_order_id
            left join service_master sm1 on sm1.id=lo.service_id
            left join service_master sm2 on sm2.id=so.service_id
            left join patient p on lo.patient_id = p.id
            left join specimen_master sp on sp.id=lo.specimen_id
            left join container_master cm on cm.id=sm1.container_id
            left join lab_order_status ls on ls.id=lo.status
            left join unit_master uo on lo.result_unit=uo.id
            left join service_alpha_normal sn on sn.service_id=sm1.id
            where lo.status=4 and p.id=? and  cast(lo.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY lo.service_order_id ASC";
        $query=$this->db->query($sql,array($labno,$frmdate,$todate));
        return $query->result();

    }
    public function search_date_status5($frmdate,$todate)
    {

        $sql="select concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno, sm2.name as order_service,sm1.name as lab_service,lo.service_order_id as order_id,
            lo.id as lab_order_id,lo.alpha_result,lo.numeric_result,lo.report_name,lo.certified_by,lo.certified_date_time,lo.rectified_by,lo.rectified_date_time,lo.saved_by,lo.saved_date_time,
            sp.name as specimen,lo.priority as priority,uo.name as unit,lo.result_type,lo.normal_range_from,lo.normal_range_to,sn.alpha_normal,
            lo.ordered_by,lo.ordered_date_time,lo.received_by,lo.received_date_time,cm.name as container,ls.name as status,so.panel_yesno,lo.sample_id,lo.method_id from lab_orders lo
            left join service_order so  on so.id=lo.service_order_id
            left join service_master sm1 on sm1.id=lo.service_id
            left join service_master sm2 on sm2.id=so.service_id
            left join patient p on lo.patient_id = p.id
            left join specimen_master sp on sp.id=lo.specimen_id
            left join container_master cm on cm.id=sm1.container_id
            left join lab_order_status ls on ls.id=lo.status
            left join unit_master uo on lo.result_unit=uo.id
            left join service_alpha_normal sn on sn.service_id=sm1.id
            where lo.status=5 and  cast(lo.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY lo.service_order_id ASC";
        $query=$this->db->query($sql,array($frmdate,$todate));
        return $query->result();

    }
    public function search_labno_status5($labno,$frmdate,$todate)
    {

        $sql="select concat(p.first_name,' ',p.last_name) as patient_name,p.id as labno, sm2.name as order_service,sm1.name as lab_service,lo.service_order_id as order_id,
            lo.id as lab_order_id,lo.alpha_result,lo.numeric_result,lo.report_name,lo.certified_by,lo.certified_date_time,lo.rectified_by,lo.rectified_date_time,lo.saved_by,lo.saved_date_time,
            sp.name as specimen,lo.priority as priority,uo.name as unit,lo.result_type,lo.normal_range_from,lo.normal_range_to,sn.alpha_normal,
            lo.ordered_by,lo.ordered_date_time,lo.received_by,lo.received_date_time,cm.name as container,ls.name as status,so.panel_yesno,lo.sample_id,lo.method_id from lab_orders lo
            left join service_order so  on so.id=lo.service_order_id
            left join service_master sm1 on sm1.id=lo.service_id
            left join service_master sm2 on sm2.id=so.service_id
            left join patient p on lo.patient_id = p.id
            left join specimen_master sp on sp.id=lo.specimen_id
            left join container_master cm on cm.id=sm1.container_id
            left join lab_order_status ls on ls.id=lo.status
            left join unit_master uo on lo.result_unit=uo.id
            left join service_alpha_normal sn on sn.service_id=sm1.id
            where lo.status=5 and p.id=? and  cast(lo.ordered_date_time as DATE) BETWEEN ? and ? ORDER BY lo.service_order_id ASC";
        $query=$this->db->query($sql,array($labno,$frmdate,$todate));
        return $query->result();

    }
    public function update_result($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('lab_orders', $data);

// was there any update or error?
        if ($this->db->affected_rows() == '1') {
            return true;
        } else {
            // any trans error?

            return false;


        }
    }
    public function getmethod()
    {
        $this->db->where('active_yesno',1);
        $query=$this->db->get('method_master');
        return $query->result();
    }



}