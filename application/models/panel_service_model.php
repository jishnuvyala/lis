<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 24-11-2015
 * Time: 15:01
 */
class Panel_service_model extends CI_Model
{

   public function find_panel()
   {
       $this->db->select('id,name');
       $this->db->where('panel_yesno',1);
       $this->db->where('active_yesno',1);
       $query=$this->db->get('service_master');
       return $query->result();
   }
    public function find_service()
    {
        $this->db->select('id,name');
        $this->db->where('panel_yesno !=',1);

        $this->db->where('active_yesno',1);
        $query=$this->db->get('service_master');
        return $query->result();
    }
    public function search_mapping($panel_id)
{
    $sql="SELECT p.panel_id,p.service_id ,s1.name AS panel,s2.name AS service FROM panel_service p
LEFT JOIN service_master s1 ON s1.id=p.panel_id
LEFT JOIN service_master s2 ON s2.id=p.service_id
WHERE p.panel_id=?";
    $query=$this->db->query($sql,array($panel_id));
    return $query->result();
}

    public function delete($panel_id,$service_id)
    {
        $this->db->where('panel_id',$panel_id);
        $this->db->where('service_id',$service_id);
        $query=$this->db->delete('panel_service');
       if($this->db->affected_rows()>0)
       {
           return true;
       }
        else{
            return false;
        }
    }
    public function check_map($panel_id,$service_id)
    {
        $this->db->where('panel_id',$panel_id);
        $this->db->where('service_id',$service_id);
        $query=$this->db->get('panel_service');
        if($query->num_rows >0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function add($data)
    {
        $this->db->insert('panel_service',$data);
        if($this->db->affected_rows() > 0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }




}